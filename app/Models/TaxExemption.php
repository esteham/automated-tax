<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxExemption extends Model
{
    protected $fillable = [
        'tax_return_id',
        'exemption_type',
        'description',
        'amount',
        'details',
        'document_path',
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
