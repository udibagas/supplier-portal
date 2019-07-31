<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceSubmission extends Model
{
    protected $fillable = [
        'vendor_id', 'user_id', 'invoice_date', 'invoice_number',
        'faktur_number', 'faktur_date', 'status', 'term_of_payment', 'total'
    ];
}
