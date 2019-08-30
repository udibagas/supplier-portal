<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceSubmissionIdOnItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_submission_items', function (Blueprint $table) {
            $table->bigInteger('invoice_submission_id');
            $table->string('text')->nullable()->change();
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
            $table->dropColumn('invoice_submission_id');
        });
    }
}
