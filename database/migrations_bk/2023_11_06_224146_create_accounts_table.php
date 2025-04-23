<?php

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
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->integer('number');
            $table->timestamps();
            $table->string('last_ip_address', 20)->nullable();
            $table->string('address_line1', 50)->nullable();
            $table->string('fname', 20)->nullable();
            $table->string('lname', 20)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('postcode', 20)->nullable();
            $table->unsignedInteger('province_id')->nullable()->index();
            $table->timestamp('last_login_time')->nullable();
            $table->string('identification', 100)->nullable();
            $table->boolean('verification_status')->default(false);
            $table->timestamp('upload_id_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
