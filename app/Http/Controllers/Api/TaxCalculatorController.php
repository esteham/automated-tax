<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TaxCalculationService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaxCalculatorController extends Controller
{
    protected $taxCalculationService;

    public function __construct(TaxCalculationService $taxCalculationService)
    {
        $this->taxCalculationService = $taxCalculationService;
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'income' => 'required|numeric|min:0',
            'filing_type' => ['required', Rule::in(['individual', 'business', 'freelancer'])],
            'year' => 'required|string',
        ]);

        try {
            // Calculate tax using the TaxCalculationService
            $result = $this->taxCalculationService->calculateTax(
                (float) $validated['income'],
                $validated['filing_type']
            );

            return response()->json([
                'success' => true,
                'taxable_income' => (float) $validated['income'], // In a real app, this would be after exemptions
                'tax_amount' => $result['total_tax'],
                'effective_tax_rate' => $result['effective_tax_rate'],
                'tax_brackets' => $result['tax_brackets'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate tax: ' . $e->getMessage(),
            ], 500);
        }
    }
}
