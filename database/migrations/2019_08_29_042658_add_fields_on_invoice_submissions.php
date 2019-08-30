<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnInvoiceSubmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_submissions', function (Blueprint $table) {
            $table->dropColumn('term_of_payment');
            $table->bigInteger('payment_term_id');
            $table->date('due_date')->nullable();
            $table->bigInteger('wht_type_id')->nullable();
            $table->bigInteger('wht_code_id')->nullable();
            $table->bigInteger('wht_base_amount')->nullable();
            $table->bigInteger('wht_amount')->nullable();
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
            $table->string('term_of_payment');
            $table->dropColumn([
                'payment_term_id', 'due_date',
                'wht_type_id', 'wht_code_id',
                'wht_base_amount', 'wht_amount'
            ]);
        });
    }
}
