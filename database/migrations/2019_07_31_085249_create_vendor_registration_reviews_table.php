<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorRegistrationReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_registration_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vendor_id');
            $table->bigInteger('user_id')->comment('user yg melakukan review');
            $table->boolean('status')->comment('0 = draft, 1 = submitted');
            $table->boolean('verification_status')->default(0)->comment('0 = on review, 1 = rejected, 2 = verified');
            $table->text('note');
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
        Schema::dropIfExists('vendor_registration_reviews');
    }
}
