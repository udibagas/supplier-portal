<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceSubmissionAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_submission_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invoice_submission_id');
            $table->string('name')->comment('invoice doc, faktur doc, bast doc, others');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_submission_attachments');
    }
}
