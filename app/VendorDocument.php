<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorDocument extends Model
{
    protected $fillable = ['vendor_id', 'name', 'file_path', 'expiry_date'];
}
