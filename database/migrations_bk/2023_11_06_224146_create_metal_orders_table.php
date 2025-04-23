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
        Schema::create('metal_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('metal_id')->nullable();
            $table->float('quantity_oz', 10, 0)->nullable();
            $table->float('price_per_oz', 10, 0)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('by_admin')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->integer('currency_id')->nullable();
            $table->softDeletes();
            $table->integer('status_id')->nullable();
            $table->integer('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metal_orders');
    }
};
