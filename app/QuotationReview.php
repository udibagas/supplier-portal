<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationReview extends Model
{
    protected $fillable = ['quotation_id', 'user_id', 'status', 'note'];
}
