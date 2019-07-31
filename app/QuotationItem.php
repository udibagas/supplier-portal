<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    protected $fillable = [
        'quotation_id', 'part_number', 'part_description',
        'requested_qty', 'requested_delivery_date', 'remark',
        'attachment', 'promised_qty', 'promised_delivery_date', 'price'
    ];
}
