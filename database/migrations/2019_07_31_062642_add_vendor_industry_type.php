<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVendorIndustryType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industry_type_vendor', function (Blueprint $table) {
            $table->bigInteger('vendor_id');
            $table->bigInteger('industry_type_id');
        });

        Schema::table('industry_type_vendor', function (Blueprint $table) {
            $table->primary(['vendor_id', 'industry_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('industry_type_vendor', function (Blueprint $table) {
            //
        });
    }
}
