<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorCompanyManagement extends Model
{
    protected $fillable = [
        'vendor_id', 'type', 'name', 'id_number',
        'position', 'religion', 'date_of_birth'
    ];
}
