<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'name',
        'designation',
        'phone',
        'phone2',
        'email',
        'organization_id',
        'organization_address_id',
        'profile_picture',
    ];

    /**
     * Get the profile picture URL for the receipt.
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('uploads/receipts/' . $this->profile_picture);
        }
        return null;
    }

    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $w) {
            $initials .= strtoupper(substr($w, 0, 1));
        }
        return $initials;
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function organizationAddress()
    {
        return $this->belongsTo(OrganizationAddress::class, 'organization_address_id');
    }
}