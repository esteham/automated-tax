<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; 

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;
    
    /**
     * Get the tax profile associated with the user.
     */
    public function taxProfile()
    {
        return $this->hasOne(TaxProfile::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username', // Made nullable in database
        'email',
        'phone',
        'security_pin',
        'password',
        'status',
        'otp',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var list<string>
     */
    protected $dates = [
        'otp_expires_at',
    ];

    public function taxpayer()
    {
        return $this->hasOne(Taxpayer::class);
    }

    public function taxReturns()
    {
        return $this->hasManyThrough(TaxReturn::class, Taxpayer::class);
    }

    public function hasCompletedProfile(): bool
    {
        return $this->taxpayer !== null && 
               $this->taxpayer->nid !== null && 
               $this->phone_verified_at !== null;
    }

}
