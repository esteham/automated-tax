<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomeSource extends Model
{
    protected $fillable = [
        'tax_return_id',
        'source_type',
        'source_name',
        'amount',
        'details',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'details' => 'array',
    ];

    public function taxReturn(): BelongsTo
    {
        return $this->belongsTo(TaxReturn::class);
    }
}
