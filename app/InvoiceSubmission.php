<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceSubmission extends Model
{
    protected $fillable = [
        'vendor_id', 'user_id', 'invoice_date', 'invoice_number',
        'faktur_number', 'faktur_date', 'status', 'term_of_payment', 'total',
        'payment_term_id', 'due_date', 'wht_type_id', 'wht_code_id', 'currency',
        'wht_base_amount', 'wht_amount', 'ppn_amount', 'baseline_date'
    ];

    protected $with = ['items', 'attachments'];

    public function items() {
        return $this->hasMany(InvoiceSubmissionItem::class);
    }

    public function attachments() {
        return $this->hasMany(InvoiceSubmissionAttachment::class);
    }
}
