<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationPhone extends Model
{
    protected $fillable = [
        'phone',
        'organization_id',
    ];
}
