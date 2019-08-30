<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceSubmissionItem extends Model
{
    protected $fillable = [
        'po_number', 'po_date', 'currency', 'po_item', 'description',
        'qty', 'uom', 'price', 'total', 'text', 'pph', 'pph_amount',
        'invoice_submission_id', 'ppn', 'ppn_amount'
    ];

    protected $casts = ['pph' => 'boolean'];
}
