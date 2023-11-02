<?php

use App\Constant\AppConstant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('role_id');
            $table->smallInteger('status')->default(AppConstant::STATUS_ACTIVE);
            $table->boolean('ad_login')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('unlocked_time')->nullable();
            $table->string('team_permissions')->nullable();
            $table->timestamp('last_login_time')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
