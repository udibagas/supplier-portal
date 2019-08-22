<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorRegistrationReview extends Model
{
    protected $fillable = [
        'vendor_id', 'user_id', 'status',
        'verification_status', 'note'
    ];

    protected $with = ['user'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }
}
