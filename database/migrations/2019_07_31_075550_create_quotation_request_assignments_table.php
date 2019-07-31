<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationRequestAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_request_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quotation_request_id');
            $table->bigInteger('user_id')->comment('user yg melakukan assignment');
            $table->boolean('status')->default(0)->comment('0 = draft, 1 = submitted');
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
        Schema::dropIfExists('quotation_request_assignments');
    }
}
