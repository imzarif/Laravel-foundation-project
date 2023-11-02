<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constant\AppConstant;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otp_histories', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('uuid');
            $table->string('otp');
            $table->smallInteger('otp_send_no');
            $table->enum('status', AppConstant::getOtpStatus());
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
        Schema::dropIfExists('otp_histories');
    }
};
