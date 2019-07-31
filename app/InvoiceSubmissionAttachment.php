<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceSubmissionAttachment extends Model
{
    protected $fillable = ['invoice_submission_id', 'name', 'file_path'];
}
