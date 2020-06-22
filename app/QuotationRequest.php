<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QuotationRequest extends Model
{
    protected $fillable = [
        'user_id', 'department_id', 'request_number',
        'status', 'subject'
    ];

    protected $with = ['vendorAssignments', 'vendorQuotations'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function items()
    {
        return $this->hasMany(QuotationRequestItem::class);
    }

    public function vendorAssignments()
    {
        return $this->hasMany(VendorAssignmentQuotationRequest::class);
    }

    public function assignments()
    {
        return $this->hasMany(QuotationRequestAssignment::class);
    }

    public function vendorQuotations()
    {
        return $this->hasMany(Quotation::class);
    }
}
