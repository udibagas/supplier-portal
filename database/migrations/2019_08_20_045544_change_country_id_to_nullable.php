<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCountryIdToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->bigInteger('country_id')->nullable()->change();
            $table->bigInteger('province_id')->nullable()->change();
            $table->bigInteger('city_id')->nullable()->change();
            $table->bigInteger('account_group_id')->nullable();
            $table->string('industry_type')->nullable();
            $table->string('product_type')->nullable();
            $table->boolean('verification_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn([
                'account_group_id', 'industry_type',
                'product_type', 'verification_status'
            ]);
        });
    }
}
