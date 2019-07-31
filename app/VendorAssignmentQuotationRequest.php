<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorAssignmentQuotationRequest extends Model
{
    protected $fillable = [
        'vendor_id', 'user_id', 'quotation_request_id',
        'quotation_request_assignment_id', 'status'
    ];
}
