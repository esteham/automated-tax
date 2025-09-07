<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxExemptionType extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'max_amount',
        'is_active',
    ];

    protected $casts = [
        'max_amount' => 'float',
        'is_active' => 'boolean',
    ];
}
