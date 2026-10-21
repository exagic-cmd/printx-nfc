<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
     use HasFactory;
    protected $fillable = [
        'name',
        'designation',
        'company',
        'phone',
        'office_phone',
        'email',
        'website',
        'facebook',
        'instagram',
        'address'
    ];
}
