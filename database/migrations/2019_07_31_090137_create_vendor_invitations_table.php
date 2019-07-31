<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_invitations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('yang menginvite');
            $table->string('name')->comment('nama kontak');
            $table->string('email')->comment('email kontak');
            $table->string('company_name');
            $table->text('invitation_url');
            $table->boolean('status')->default(0)->comment('0 = draft, 1 = submitted');
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
        Schema::dropIfExists('vendor_invitations');
    }
}
