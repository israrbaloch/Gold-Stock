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
        Schema::create('additional_percents', function (Blueprint $table) {
            $table->increments('id');
            $table->float('percent', 10, 0);
            $table->string('type', 250);
            $table->string('sign', 250);
            $table->timestamp('edited_time')->useCurrentOnUpdate()->useCurrent();
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
        Schema::dropIfExists('additional_percents');
    }
};
