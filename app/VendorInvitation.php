<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorInvitation extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'company_name',
        'invitation_url', 'status'
    ];
}
