<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceSubmissionReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_submission_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->tinyInteger('verification_type')->comment('1 = matching document, 2 = matching tax, 3 = verifikasi dana');
            $table->boolean('status')->default(0)->comment('0 = draft, 1 = submitted');
            $table->tinyInteger('verification_status')->default(0)->comment('0 = on review, 1 = rejected, 2 = verified');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('invoice_submission_reviews');
    }
}
