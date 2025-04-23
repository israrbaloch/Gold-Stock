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
        Schema::create('cash_withdrawals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('currency_id')->nullable();
            $table->float('value', 10, 0)->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('metal_order_id')->nullable();
            $table->integer('payment_method_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->string('bank_name', 50)->nullable();
            $table->string('bank_address', 50)->nullable();
            $table->string('account_number', 50)->nullable();
            $table->string('institution_number', 50)->nullable();
            $table->string('transit_number', 50)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_withdrawals');
    }
};
