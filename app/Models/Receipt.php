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

    public static function encodeId($id)
    {
        $key = 0x5A3B124C;
        return str_pad(dechex($id ^ $key), 8, '0', STR_PAD_LEFT);
    }

    public static function decodeId($encoded)
    {
        $key = 0x5A3B124C;
        if (!ctype_xdigit($encoded) || strlen($encoded) !== 8) {
            return null;
        }
        return hexdec($encoded) ^ $key;
    }
}