<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationRequestAssignment extends Model
{
    protected $fillable = ['quotation_request_id', 'user_id', 'status'];

    public function vendors() {
        return $this->hasMany(VendorAssignmentQuotationRequest::class);
    }
}
