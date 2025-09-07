<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaxReturn;
use App\Models\IncomeSource;
use App\Models\TaxExemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaxReturnController extends Controller
{
    /**
     * Get the current user's tax returns.
     */
    public function index()
    {
        $user = auth()->user();
        $returns = $user->taxReturns()
            ->with(['incomeSources', 'exemptions', 'payments'])
            ->orderBy('filing_year', 'desc')
            ->get();

        return response()->json([
            'data' => $returns,
        ]);
    }

    /**
     * Store a newly created tax return in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filing_year' => 'required|string|size:4',
            'filing_type' => ['required', Rule::in(['individual', 'business', 'freelancer'])],
            'income_sources' => 'required|array|min:1',
            'income_sources.*.source_type' => 'required|string|max:50',
            'income_sources.*.source_name' => 'required|string|max:255',
            'income_sources.*.amount' => 'required|numeric|min:0',
            'income_sources.*.details' => 'nullable|array',
            'exemptions' => 'nullable|array',
            'exemptions.*.exemption_type' => 'required_with:exemptions|string|max:50',
            'exemptions.*.description' => 'required_with:exemptions|string|max:255',
            'exemptions.*.amount' => 'required_with:exemptions|numeric|min:0',
            'exemptions.*.document_path' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $user = $request->user();
        $taxpayer = $user->taxpayer;

        // Check if a return already exists for this year
        $existingReturn = $taxpayer->taxReturns()
            ->where('filing_year', $validated['filing_year'])
            ->first();

        if ($existingReturn) {
            return response()->json([
                'message' => 'A tax return already exists for the specified year',
                'data' => $existingReturn,
            ], 409);
        }

        // Start database transaction
        return \DB::transaction(function () use ($validated, $taxpayer) {
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
                $source = $taxReturn->incomeSources()->create($incomeSource);
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

            // Calculate tax
            $taxableIncome = max(0, $totalIncome - $totalExemptions);
            $taxAmount = $this->calculateTax($taxableIncome, $validated['filing_type']);

            // Update tax return with calculated values
            $taxReturn->update([
                'total_income' => $totalIncome,
                'taxable_income' => $taxableIncome,
                'tax_amount' => $taxAmount,
            ]);

            // Load relationships for response
            $taxReturn->load(['incomeSources', 'exemptions']);

            return response()->json([
                'message' => 'Tax return created successfully',
                'data' => $taxReturn,
            ], 201);
        });
    }

    /**
     * Display the specified tax return.
     */
    public function show(TaxReturn $taxReturn)
    {
        $this->authorize('view', $taxReturn);
        
        $taxReturn->load(['incomeSources', 'exemptions', 'payments']);
        
        return response()->json([
            'data' => $taxReturn,
        ]);
    }

    /**
     * Submit the tax return for processing.
     */
    public function submit(TaxReturn $taxReturn)
    {
        $this->authorize('submit', $taxReturn);

        if ($taxReturn->status !== 'draft') {
            return response()->json([
                'message' => 'This return cannot be submitted',
            ], 400);
        }

        $taxReturn->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        // TODO: Send notification to taxpayer and tax authority

        return response()->json([
            'message' => 'Tax return submitted successfully',
            'data' => $taxReturn->fresh(),
        ]);
    }

    /**
     * Calculate tax based on taxable income and filing type.
     */
    protected function calculateTax(float $taxableIncome, string $filingType): float
    {
        // This is a simplified example - replace with actual tax calculation logic
        // Based on Bangladesh tax rates for the 2023-2024 fiscal year
        
        // Tax rates for individuals
        if ($filingType === 'individual') {
            if ($taxableIncome <= 350000) {
                return 0; // No tax for income up to 350,000
            } elseif ($taxableIncome <= 450000) {
                return ($taxableIncome - 350000) * 0.05;
            } elseif ($taxableIncome <= 750000) {
                return 5000 + (($taxableIncome - 450000) * 0.1);
            } elseif ($taxableIncome <= 1150000) {
                return 35000 + (($taxableIncome - 750000) * 0.15);
            } elseif ($taxableIncome <= 1650000) {
                return 95000 + (($taxableIncome - 1150000) * 0.2);
            } else {
                return 195000 + (($taxableIncome - 1650000) * 0.25);
            }
        } 
        // Different rates for businesses and freelancers
        else {
            if ($taxableIncome <= 500000) {
                return $taxableIncome * 0.05;
            } elseif ($taxableIncome <= 2000000) {
                return 25000 + (($taxableIncome - 500000) * 0.1);
            } elseif ($taxableIncome <= 3500000) {
                return 175000 + (($taxableIncome - 2000000) * 0.15);
            } elseif ($taxableIncome <= 5000000) {
                return 400000 + (($taxableIncome - 3500000) * 0.2);
            } else {
                return 700000 + (($taxableIncome - 5000000) * 0.25);
            }
        }
    }
}
