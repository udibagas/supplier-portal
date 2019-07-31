<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quotation_request_id');
            $table->bigInteger('vendor_id');
            $table->bigInteger('user_id')->comment('vendor user');
            $table->string('quotation_number');
            $table->string('currency', 20);
            $table->string('term_of_payment');
            $table->string('inco_term');
            $table->tinyInteger('status')->default(0)->comment('0 = draft, 1 = submitted, 2 = rejected, 3 = approved');
            $table->bigInteger('approver_id')->nullable();
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
        Schema::dropIfExists('quotations');
    }
}
