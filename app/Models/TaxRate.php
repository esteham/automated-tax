<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    protected $fillable = [
        'filing_type',
        'min_income',
        'max_income',
        'rate',
        'description',
    ];

    protected $casts = [
        'min_income' => 'float',
        'max_income' => 'float',
        'rate' => 'float',
    ];

    /**
     * Scope a query to only include rates for a specific filing type.
     */
    public function scopeForFilingType($query, $filingType)
    {
        return $query->where('filing_type', $filingType);
    }

    /**
     * Calculate tax based on income and filing type.
     */
    public static function calculateTax(float $taxableIncome, string $filingType): float
    {
        $rates = static::forFilingType($filingType)
            ->orderBy('min_income')
            ->get();

        $tax = 0;
        $remainingIncome = $taxableIncome;

        foreach ($rates as $rate) {
            if ($remainingIncome <= 0) {
                break;
            }

            $bracketIncome = $rate->max_income 
                ? min($remainingIncome, $rate->max_income - $rate->min_income + 1)
                : $remainingIncome;

            $tax += $bracketIncome * ($rate->rate / 100);
            $remainingIncome -= $bracketIncome;
        }

        return $tax;
    }
}
