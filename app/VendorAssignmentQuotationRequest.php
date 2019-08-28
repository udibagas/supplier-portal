<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorAssignmentQuotationRequest extends Model
{
    protected $fillable = [
        'vendor_id', 'user_id', 'quotation_request_id',
        'quotation_request_assignment_id', 'status'
    ];

    protected $with = ['vendor', 'assignment'];

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }

    public function assignment() {
        return $this->belongsTo(QuotationRequestAssignment::class, 'quotation_request_assignment_id');
    }
}
