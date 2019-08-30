<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTerm extends Model
{
    protected $fillable = ['code', 'description', 'days'];
}
