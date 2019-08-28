<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationRequestItem extends Model
{
    protected $fillable = [
        'quotation_request_id', 'part_number', 'part_description',
        'requested_qty', 'unit', 'requested_delivery_date', 'remark', 'attachment'
    ];
}
