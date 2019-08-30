<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnInvoiceSubmissionItems1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_submission_items', function (Blueprint $table) {
            $table->boolean('ppn')->default(1);
            $table->bigInteger('ppn_amount')->default(0);
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
            $table->dropColumn(['ppn', 'ppn_amount']);
        });
    }
}
