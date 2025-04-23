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
        Schema::create('ic_fedex', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_id');
            $table->string('service', 250);
            $table->float('price', 10, 0);
            $table->string('currency', 100);
            $table->text('tracking_number')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('date_confirmed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ic_fedex');
    }
};
