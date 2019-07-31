<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderVendor extends Model
{
    protected $fillable = [
        'po_number', 'po_date', 'currency', 'po_item',
        'qty', 'uom', 'price', 'total', 'text', 'delivery_date',
        'gr_status', 'invoice_status'
    ];
}
