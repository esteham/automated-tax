<?php

namespace App\Http\Controllers\Tax;

use App\Http\Controllers\Controller;
use App\Models\TaxReturn;
use App\Models\TaxExemption;
use App\Models\IncomeSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Services\TaxCalculationService;

class TaxController extends Controller
{
    /**
     * Show the tax dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $taxpayer = $user->taxpayer;
        
        $currentYear = now()->format('Y');
        $currentReturn = $taxpayer->taxReturns()
            ->where('filing_year', $currentYear)
            ->latest()
            ->first();

        $recentReturns = $taxpayer->taxReturns()
            ->where('filing_year', '!=', $currentYear)
            ->orderBy('filing_year', 'desc')
            ->take(5)
            ->get();

        return Inertia::render('Tax/Dashboard', [
            'currentYear' => $currentYear,
            'currentReturn' => $currentReturn,
            'recentReturns' => $recentReturns,
            'hasCompletedProfile' => $user->hasCompletedProfile(),
        ]);
    }

    /**
     * Show the form for creating a new tax return.
     */
    public function createReturn()
    {
        $user = Auth::user();
        
        if (!$user->hasCompletedProfile()) {
            return redirect()->route('profile.edit')
                ->with('warning', 'Please complete your profile before filing a tax return.');
        }

        $currentYear = now()->format('Y');
        
        if ($user->taxpayer->hasFiledForYear($currentYear)) {
            return redirect()->route('tax.returns.show', [
                'taxReturn' => $user->taxpayer->getCurrentYearReturn()->id
            ])->with('info', 'You have already filed a return for the current year.');
        }

        return Inertia::render('Tax/Returns/Create', [
            'filingYear' => $currentYear,
            'taxpayerType' => $user->taxpayer->taxpayer_type,
        ]);
    }

    /**
     * Store a newly created tax return in storage.
     */
    public function storeReturn(Request $request)
    {
        $validated = $request->validate([
            'filing_year' => 'required|string|size:4',
            'filing_type' => 'required|in:individual,business,freelancer',
            'income_sources' => 'required|array|min:1',
            'income_sources.*.source_type' => 'required|string',
            'income_sources.*.source_name' => 'required|string|max:255',
            'income_sources.*.amount' => 'required|numeric|min:0',
            'exemptions' => 'nullable|array',
            'exemptions.*.exemption_type' => 'required|string',
            'exemptions.*.description' => 'required|string|max:255',
            'exemptions.*.amount' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $taxpayer = $user->taxpayer;

        // Create the tax return
        $taxReturn = $taxpayer->taxReturns()->create([
            'filing_year' => $validated['filing_year'],
            'filing_type' => $validated['filing_type'],
            'status' => 'draft',
            'total_income' => 0,
            'taxable_income' => 0,
            'tax_amount' => 0,
        ]);

        // Add income sources
        $totalIncome = 0;
        foreach ($validated['income_sources'] as $incomeSource) {
            $taxReturn->incomeSources()->create($incomeSource);
            $totalIncome += $incomeSource['amount'];
        }

        // Add exemptions
        $totalExemptions = 0;
        if (!empty($validated['exemptions'])) {
            foreach ($validated['exemptions'] as $exemption) {
                $taxReturn->exemptions()->create($exemption);
                $totalExemptions += $exemption['amount'];
            }
        }

        // Calculate tax using the TaxCalculationService
        $taxService = new TaxCalculationService();
        $taxableIncome = max(0, $totalIncome - $totalExemptions);
        $taxCalculation = $taxService->calculateTax($taxableIncome, $validated['filing_type']);

        // Update tax return with calculated values
        $taxReturn->update([
            'total_income' => $totalIncome,
            'taxable_income' => $taxableIncome,
            'tax_amount' => $taxCalculation['total_tax'],
            'calculation_details' => [
                'tax_brackets' => $taxCalculation['tax_brackets'],
                'effective_tax_rate' => $taxCalculation['effective_tax_rate'],
                'calculation_date' => now()->toDateTimeString(),
            ],
        ]);

        return redirect()->route('tax.returns.show', $taxReturn)
            ->with('success', 'Tax return created successfully.');
    }

    /**
     * Display the specified tax return.
     */
    public function showReturn(TaxReturn $taxReturn)
    {
        $this->authorize('view', $taxReturn);
        
        $taxReturn->load(['incomeSources', 'exemptions', 'payments']);
        
        return Inertia::render('Tax/Returns/Show', [
            'taxReturn' => $taxReturn,
            'canSubmit' => $taxReturn->status === 'draft',
            'canPay' => $taxReturn->status === 'submitted' && $taxReturn->tax_amount > $taxReturn->paid_amount,
        ]);
    }

    /**
     * Submit the tax return for processing.
     */
    public function submitReturn(TaxReturn $taxReturn)
    {
        $this->authorize('submit', $taxReturn);

        if ($taxReturn->status !== 'draft') {
            return back()->with('error', 'This return cannot be submitted.');
        }

        // Recalculate tax before submission to ensure accuracy
        $taxService = new TaxCalculationService();
        $taxReturn = $taxService->recalculateTax($taxReturn);

        $taxReturn->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        // TODO: Send notification to taxpayer and tax authority

        return redirect()->route('tax.returns.show', $taxReturn)
            ->with('success', 'Tax return submitted successfully.');
    }
}
