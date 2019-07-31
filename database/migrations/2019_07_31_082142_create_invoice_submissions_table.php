<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_submissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vendor_id');
            $table->bigInteger('user_id');
            $table->date('invoice_date');
            $table->string('invoice_number');
            $table->string('faktur_number');
            $table->date('faktur_date');
            $table->tinyInteger('status')->default(0)->comment('0 = draft, 1 = submitted, 2 = on review, 3 = approved, 4 = rejected');
            $table->string('term_of_payment');
            $table->bigInteger('total')->default(0);
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
        Schema::dropIfExists('invoice_submissions');
    }
}
