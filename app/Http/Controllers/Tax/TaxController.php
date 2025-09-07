<?php

namespace App\Http\Controllers\Tax;

use App\Http\Controllers\Controller;
use App\Models\TaxReturn;
use App\Models\TaxExemption;
use App\Models\IncomeSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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

        // Calculate tax (simplified calculation - should be replaced with actual tax calculation logic)
        $taxableIncome = max(0, $totalIncome - $totalExemptions);
        $taxAmount = $this->calculateTax($taxableIncome, $validated['filing_type']);

        // Update tax return with calculated values
        $taxReturn->update([
            'total_income' => $totalIncome,
            'taxable_income' => $taxableIncome,
            'tax_amount' => $taxAmount,
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

        $taxReturn->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        // TODO: Send notification to taxpayer and tax authority

        return redirect()->route('tax.returns.show', $taxReturn)
            ->with('success', 'Tax return submitted successfully.');
    }

    /**
     * Calculate tax based on taxable income and filing type.
     * This is a simplified example - replace with actual tax calculation logic.
     */
    protected function calculateTax(float $taxableIncome, string $filingType): float
    {
        // Simplified tax calculation - replace with actual tax brackets and rates
        if ($taxableIncome <= 300000) {
            return 0; // No tax for income up to 300,000
        } elseif ($taxableIncome <= 400000) {
            return ($taxableIncome - 300000) * 0.05;
        } elseif ($taxableIncome <= 700000) {
            return 5000 + (($taxableIncome - 400000) * 0.1);
        } elseif ($taxableIncome <= 1100000) {
            return 35000 + (($taxableIncome - 700000) * 0.15);
        } elseif ($taxableIncome <= 1600000) {
            return 95000 + (($taxableIncome - 1100000) * 0.2);
        } else {
            return 195000 + (($taxableIncome - 1600000) * 0.25);
        }
    }
}
