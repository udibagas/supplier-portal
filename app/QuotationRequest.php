<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationRequest extends Model
{
    protected $fillable = [
        'user_id', 'department_id', 'request_number',
        'status', 'subject'
    ];
}
