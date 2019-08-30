<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnInvoiceSubmissionItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_submission_items', function (Blueprint $table) {
            $table->dropColumn('delivery_date');
            $table->string('description');
            $table->boolean('pph')->default(0);
            $table->bigInteger('pph_amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_submission_items', function (Blueprint $table) {
            $table->date('delivery_date')->nullable();
            $table->dropColumn([ 'pph', 'pph_amount', 'description' ]);
        });
    }
}
