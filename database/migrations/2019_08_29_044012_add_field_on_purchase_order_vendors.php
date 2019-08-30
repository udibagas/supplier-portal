<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldOnPurchaseOrderVendors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_vendors', function (Blueprint $table) {
            $table->bigInteger('vendor_id');
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order_vendors', function (Blueprint $table) {
            $table->dropColumn('description', 'vendor_id');
        });
    }
}
