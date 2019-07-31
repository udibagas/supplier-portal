<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceSubmissionReview extends Model
{
    protected $fillable = ['verification_type', 'status', 'verification_status', 'note'];
}
