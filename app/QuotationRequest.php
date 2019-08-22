<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationRequest extends Model
{
    protected $fillable = [
        'user_id', 'department_id', 'request_number',
        'status', 'subject'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function items() {
        return $this->hasMany(QuotationRequestItem::class);
    }
}
