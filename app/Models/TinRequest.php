<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TinRequest extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'nid_number',
        'date_of_birth',
        'father_name',
        'mother_name',
        'spouse_name',
        'present_address',
        'permanent_address',
        'occupation',
        'company_name',
        'company_address',
        'purpose',
        'status',
        'tin_number',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'certificate_path',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the user that owns the TIN request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who approved/rejected the request.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Check if the request is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the request is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the request is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}
