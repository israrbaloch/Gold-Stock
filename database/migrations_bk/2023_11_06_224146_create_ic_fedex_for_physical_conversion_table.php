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
        Schema::create('ic_fedex_for_physical_conversion', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('physical_conversion_id');
            $table->string('service', 250);
            $table->float('price', 10, 0);
            $table->string('currency', 100);
            $table->text('tracking_number')->nullable();
            $table->bigInteger('date_created');
            $table->bigInteger('date_confirmed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ic_fedex_for_physical_conversion');
    }
};
