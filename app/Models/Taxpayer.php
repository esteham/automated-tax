<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Taxpayer extends Model implements HasMedia
{
    
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'tin_number',
        'taxpayer_type',
        'business_name',
        'business_type',
        'nid',
        'address',
        'bank_details',
        'date_of_birth',
        'gender',
        'occupation',
        'tax_circle',
        'tax_zone',
    ];

    protected $casts = [
        'bank_details' => 'array',
        'date_of_birth' => 'date',
    ];

    protected $appends = ['full_address'];

    public const TAXPAYER_TYPES = [
        'individual' => 'Individual',
        'business' => 'Business',
        'firm' => 'Firm',
        'company' => 'Company',
    ];

    public const GENDERS = [
        'male' => 'Male',
        'female' => 'Female',
        'other' => 'Other',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taxReturns()
    {
        return $this->hasMany(TaxReturn::class);
    }

    public function getFullAddressAttribute()
    {
        return $this->address;
    }

    public function getCurrentYearReturn()
    {
        $currentYear = now()->format('Y');
        return $this->taxReturns()
            ->where('filing_year', $currentYear)
            ->latest()
            ->first();
    }

    public function hasFiledForYear($year)
    {
        return $this->taxReturns()
            ->where('filing_year', $year)
            ->whereIn('status', ['submitted', 'processing', 'approved'])
            ->exists();
    }

    // KYC docs collection (private disk recommended)
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('kyc_docs')
            ->useDisk(config('filesystems.default') === 'public' ? 'private' : config('filesystems.default'))
            ->acceptsMimeTypes(['application/pdf','image/jpeg','image/png','image/webp'])
            ->singleFile(false);
    }

}
