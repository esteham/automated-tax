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
    ];

    protected $casts = [
        'bank_details' => 'array',
    ];

    public function user()
    {
        return $this->beLongsTo(User::class);
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
