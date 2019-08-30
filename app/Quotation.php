<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'quotation_request_id', 'vendor_id', 'user_id',
        'quotation_number', 'currency', 'term_of_payment',
        'inco_term', 'status', 'approver_id'
    ];

    protected $appends = ['date'];

    public function getDateAttribute() {
        return substr($this->created_at, 0, 10);
    }
}
