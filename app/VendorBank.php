<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorBank extends Model
{
    protected $fillable = [
        'vendor_id', 'bank_id', 'branch',
        'account_number', 'account_holder', 'currency'
    ];
}
