<?php

namespace App\Models;

use App\Models\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxProfile extends Model
{
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'tin_number',
        'nid_number',
        'nid_issuing_country',
        'nid_issue_date',
        'nid_expiry_date',
        'nid_front_image',
        'nid_back_image',
        'country',
        'tax_office',
        'registration_date',
        'taxpayer_type',
        'tax_identification_card',
        'address',
        'city',
        'postal_code',
        'status',
        'tin_status',
        'tin_requested_at',
        'tin_approved_at',
        'notes'
    ];

    protected $casts = [
        'registration_date' => 'date',
        'nid_issue_date' => 'date',
        'nid_expiry_date' => 'date',
        'tin_requested_at' => 'datetime',
        'tin_approved_at' => 'datetime',
    ];

    /**
     * Get the user that owns the tax profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the activities for the tax profile.
     */
    public function activities()
    {
        return $this->morphMany(\App\Models\ActivityLog::class, 'subject')
            ->latest();
    }

    /**
     * Get the URL for the NID front image.
     */
    public function getNidFrontImageUrlAttribute()
    {
        return $this->nid_front_image ? asset('storage/' . $this->nid_front_image) : null;
    }

    /**
     * Get the URL for the NID back image.
     */
    public function getNidBackImageUrlAttribute()
    {
        return $this->nid_back_image ? asset('storage/' . $this->nid_back_image) : null;
    }
}
