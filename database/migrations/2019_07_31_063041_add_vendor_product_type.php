<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVendorProductType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_type_vendor', function (Blueprint $table) {
            $table->bigInteger('vendor_id');
            $table->bigInteger('product_type_id');
        });

        Schema::table('product_type_vendor', function (Blueprint $table) {
            $table->primary(['vendor_id', 'product_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_type_vendor', function (Blueprint $table) {
            //
        });
    }
}
