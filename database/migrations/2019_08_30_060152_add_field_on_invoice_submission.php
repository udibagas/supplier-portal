<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldOnInvoiceSubmission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_submissions', function (Blueprint $table) {
            $table->bigInteger('ppn_amount')->default(0);
            $table->date('baseline_date')->nullable();
            $table->string('currency', 3)->default('IDR');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_submissions', function (Blueprint $table) {
            $table->dropColumn(['ppn_amount', 'baseline_date', 'currency']);
        });
    }
}
