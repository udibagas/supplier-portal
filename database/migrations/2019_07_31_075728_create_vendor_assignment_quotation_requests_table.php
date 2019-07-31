<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorAssignmentQuotationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_assignment_quotation_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vendor_id');
            $table->bigInteger('user_id')->comment('Vendor user');
            $table->bigInteger('quotation_request_id');
            $table->bigInteger('quotation_request_assignment_id');
            $table->tinyInteger('status')->default(0)->comment('0 = assigned, 1 = replied, 2 = rejected, 3 = approved');
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
        Schema::dropIfExists('vendor_assignment_quotation_requests');
    }
}
