<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    const STATUS_DRAFT = 0;

    const STATUS_SUBMITTED = 1;

    const STATUS_APPROVED = 2;

    const STATUS_REJECTED = 3;

    protected $fillable = [
        'quotation_request_id', 'vendor_id', 'user_id',
        'quotation_number', 'currency', 'term_of_payment',
        'inco_term', 'status', 'approver_id', 'quotation_date'
    ];

    protected $appends = ['date', 'status_name'];

    protected $with = ['vendor', 'items'];

    public function getDateAttribute()
    {
        return substr($this->created_at, 0, 10);
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function getStatusNameAttribute()
    {
        $status = [
            'Draft', 'Submitted', 'Approved', 'Rejected'
        ];

        return $status[$this->status];
    }
}
