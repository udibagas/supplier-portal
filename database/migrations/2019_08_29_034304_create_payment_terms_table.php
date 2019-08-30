<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePaymentTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_terms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 10);
            $table->string('description');
            $table->integer('days');
            $table->timestamps();
        });

        DB::table('payment_terms')->insert([
            ['code' => 'T000', 'description' => '0 days', 'days' => 0],
            ['code' => 'T003', 'description' => '3 days', 'days' => 3],
            ['code' => 'T007', 'description' => '7 days', 'days' => 7],
            ['code' => 'T014', 'description' => '14 days', 'days' => 14],
            ['code' => 'T021', 'description' => '21 days', 'days' => 21],
            ['code' => 'T030', 'description' => '30 days', 'days' => 30],
            ['code' => 'T045', 'description' => '45 days', 'days' => 45],
            ['code' => 'T060', 'description' => '60 days', 'days' => 60],
            ['code' => 'T075', 'description' => '75 days', 'days' => 75],
            ['code' => 'T090', 'description' => '90 days', 'days' => 90],
            ['code' => 'T105', 'description' => '105 days', 'days' => 105]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_terms');
    }
}
