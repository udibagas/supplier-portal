<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceSubmissionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_submission_items', function (Blueprint $table) {
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
        Schema::dropIfExists('invoice_submission_items');
    }
}
