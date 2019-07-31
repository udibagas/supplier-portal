<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorCompanyManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_company_managements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vendor_id');
            $table->string('type');
            $table->string('name');
            $table->string('id_number');
            $table->string('position');
            $table->string('religion');
            $table->date('date_of_birth')->nullable();
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
        Schema::dropIfExists('vendor_company_managements');
    }
}
