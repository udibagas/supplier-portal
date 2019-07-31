<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceSubmissionItem extends Model
{
    protected $fillable = [
        'po_number', 'po_date', 'currency', 'po_item',
        'qty', 'uom', 'price', 'total', 'text', 'delivery_date'
    ];
}
