<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationRequestAssignment extends Model
{
    protected $fillable = ['quotation_request_id', 'user_id', 'status'];

    protected $with = ['user'];

    public function vendors() {
        return $this->hasMany(VendorAssignmentQuotationRequest::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
