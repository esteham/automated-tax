<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxReturn extends Model
{
    protected $fillable = [
        'taxpayer_id',
        'filing_year',
        'filing_type',
        'status',
        'submitted_at',
        'total_income',
        'taxable_income',
        'tax_amount',
        'paid_amount',
        'payment_status',
        'challan_number',
        'payment_date',
        'notes',
        'calculation_details',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'payment_date' => 'datetime',
        'calculation_details' => 'array',
    ];

    public function taxpayer(): BelongsTo
    {
        return $this->belongsTo(Taxpayer::class);
    }

    public function incomeSources(): HasMany
    {
        return $this->hasMany(IncomeSource::class);
    }

    public function exemptions(): HasMany
    {
        return $this->hasMany(TaxExemption::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(TaxPayment::class);
    }

    public function calculateTaxableIncome(): float
    {
        $totalIncome = $this->incomeSources->sum('amount');
        $totalExemptions = $this->exemptions->sum('amount');
        
        return max(0, $totalIncome - $totalExemptions);
    }
}
