<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationRequestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_request_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quotation_request_id');
            $table->string('part_number');
            $table->string('part_description');
            $table->integer('requested_qty');
            $table->date('requested_delivery_date');
            $table->string('remark')->nullable();
            $table->string('attachment')->nullable();
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
        Schema::dropIfExists('quotation_request_items');
    }
}
