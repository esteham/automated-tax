<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxProfile extends Model
{
    protected $fillable = [
        'user_id',
        'tin_number',
        'country',
        'tax_office',
        'registration_date',
        'taxpayer_type',
        'tax_identification_card',
        'address',
        'city',
        'postal_code',
        'status',
        'notes'
    ];

    protected $casts = [
        'registration_date' => 'date',
    ];

    /**
     * Get the user that owns the tax profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
