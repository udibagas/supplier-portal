<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorRegistrationReview extends Model
{
    protected $fillable = ['vendor_id', 'user_id', 'status', 'verification_status', 'note'];
}
