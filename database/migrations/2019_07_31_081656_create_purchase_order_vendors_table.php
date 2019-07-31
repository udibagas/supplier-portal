<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('po_number');
            $table->date('po_date');
            $table->string('currency', 20);
            $table->integer('po_item');
            $table->integer('qty');
            $table->string('uom');
            $table->bigInteger('price');
            $table->bigInteger('total');
            $table->string('text');
            $table->date('delivery_date');
            $table->boolean('gr_status');
            $table->boolean('invoice_status');
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
        Schema::dropIfExists('purchase_order_vendors');
    }
}
