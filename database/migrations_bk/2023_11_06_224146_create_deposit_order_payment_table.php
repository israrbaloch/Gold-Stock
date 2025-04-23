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
        Schema::create('deposit_order_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deposit_order_id')->nullable();
            $table->integer('currency_id')->nullable();
            $table->float('value', 10, 0)->nullable();
            $table->integer('payment_method_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposit_order_payment');
    }
};
