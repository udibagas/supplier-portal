<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quotation_id');
            $table->string('part_number');
            $table->string('part_description');
            $table->integer('requested_qty');
            $table->date('requested_delivery_date');
            $table->string('remark')->nullable();
            $table->string('attachment')->nullable();
            $table->integer('promised_qty');
            $table->date('promised_elivery_date');
            $table->bigInteger('price');
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
        Schema::dropIfExists('quotation_items');
    }
}
