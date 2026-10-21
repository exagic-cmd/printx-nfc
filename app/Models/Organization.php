<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Organization extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'website', 'facebook', 'instagram',
        'office_address', 'office_number', 'fax_number', 'logo', 'color_scheme', 'background_color'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the logo URL for the organization.
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('uploads/organizations/' . $this->logo);
        }
        return null;
    }

    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $w) {
            if (!empty($w)) {
                $initials .= strtoupper(substr($w, 0, 1));
            }
        }
        return $initials;
    }
    public function addresses()
    {
        return $this->hasMany(OrganizationAddress::class);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}

