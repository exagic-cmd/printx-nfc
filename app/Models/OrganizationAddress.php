<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationAddress extends Model
{
    use HasFactory;

    protected $table = 'organization_address';

    protected $fillable = [
        'organization_id',
        'office_address',
        'office_number',
        'fax_number',
    ];

    public $timestamps = false; // Based on the DESCRIBE output earlier, it didn't show created_at/updated_at, let me check again to be sure.

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
