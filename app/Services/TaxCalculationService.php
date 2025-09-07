<?php

namespace App\Services;

use App\Models\TaxRate;
use App\Models\TaxReturn;
use Illuminate\Support\Facades\Log;

class TaxCalculationService
{
    /**
     * Calculate tax for a given taxable income and filing type.
     *
     * @param float $taxableIncome
     * @param string $filingType
     * @return array
     */
    public function calculateTax(float $taxableIncome, string $filingType): array
    {
        $tax = 0;
        $taxBrackets = [];
        
        // Get applicable tax rates for the filing type
        $rates = TaxRate::forFilingType($filingType)
            ->orderBy('min_income')
            ->get();

        $remainingIncome = $taxableIncome;
        $totalTax = 0;

        foreach ($rates as $rate) {
            if ($remainingIncome <= 0) {
                break;
            }

            $bracketMax = $rate->max_income ?? PHP_FLOAT_MAX;
            $bracketMin = $rate->min_income;
            
            // Calculate the amount of income in this bracket
            $bracketIncome = min($remainingIncome, $bracketMax - $bracketMin + 1);
            
            // Calculate tax for this bracket
            $bracketTax = $bracketIncome * ($rate->rate / 100);
            $totalTax += $bracketTax;
            
            // Add to brackets for detailed breakdown
            $taxBrackets[] = [
                'min_income' => $bracketMin,
                'max_income' => $rate->max_income,
                'rate' => $rate->rate,
                'taxable_amount' => $bracketIncome,
                'tax' => $bracketTax,
            ];

            $remainingIncome -= $bracketIncome;
        }

        return [
            'total_tax' => round($totalTax, 2),
            'tax_brackets' => $taxBrackets,
            'effective_tax_rate' => $taxableIncome > 0 ? round(($totalTax / $taxableIncome) * 100, 2) : 0,
        ];
    }

    /**
     * Calculate tax for a tax return.
     *
     * @param TaxReturn $taxReturn
     * @return array
     */
    public function calculateTaxForReturn(TaxReturn $taxReturn): array
    {
        // Load relationships if not already loaded
        if (!$taxReturn->relationLoaded('incomeSources')) {
            $taxReturn->load('incomeSources');
        }
        if (!$taxReturn->relationLoaded('exemptions')) {
            $taxReturn->load('exemptions');
        }

        // Calculate total income
        $totalIncome = $taxReturn->incomeSources->sum('amount');
        
        // Calculate total exemptions
        $totalExemptions = $taxReturn->exemptions->sum('amount');
        
        // Calculate taxable income
        $taxableIncome = max(0, $totalIncome - $totalExemptions);
        
        // Calculate tax
        $taxCalculation = $this->calculateTax($taxableIncome, $taxReturn->filing_type);
        
        return [
            'total_income' => $totalIncome,
            'total_exemptions' => $totalExemptions,
            'taxable_income' => $taxableIncome,
            'tax_amount' => $taxCalculation['total_tax'],
            'tax_brackets' => $taxCalculation['tax_brackets'],
            'effective_tax_rate' => $taxCalculation['effective_tax_rate'],
            'calculation_details' => [
                'income_sources' => $taxReturn->incomeSources->toArray(),
                'exemptions' => $taxReturn->exemptions->toArray(),
                'calculation_date' => now()->toDateTimeString(),
            ],
        ];
    }

    /**
     * Recalculate and update tax for a return.
     *
     * @param TaxReturn $taxReturn
     * @return TaxReturn
     */
    public function recalculateTax(TaxReturn $taxReturn): TaxReturn
    {
        // Only recalculate if the return is in draft status
        if ($taxReturn->status !== 'draft') {
            throw new \RuntimeException('Cannot recalculate tax for a submitted return.');
        }

        $calculation = $this->calculateTaxForReturn($taxReturn);

        $taxReturn->update([
            'total_income' => $calculation['total_income'],
            'taxable_income' => $calculation['taxable_income'],
            'tax_amount' => $calculation['tax_amount'],
            'calculation_details' => $calculation['calculation_details'],
        ]);

        return $taxReturn->fresh();
    }
}
