<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('establish_date')->nullable();
            $table->string('npwp');
            $table->bigInteger('partnership_type_id')->nullable();
            $table->bigInteger('business_entity_form')->nullable();
            $table->string('company_status');
            $table->string('address');
            $table->bigInteger('country_id');
            $table->bigInteger('province_id');
            $table->bigInteger('city_id');
            $table->bigInteger('kecamatan_id')->nullable();
            $table->bigInteger('kelurahan_id')->nullable();
            $table->integer('postcode');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_email')->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
