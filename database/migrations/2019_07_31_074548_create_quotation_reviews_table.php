<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quotation_id');
            $table->bigInteger('user_id')->comment('yang melakukan review');
            $table->tinyInteger('status')->comment('0 = rejected, 1 = approved');
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
        Schema::dropIfExists('quotation_reviews');
    }
}
