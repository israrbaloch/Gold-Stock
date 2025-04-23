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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('sku', 20)->nullable();
            $table->string('type', 4)->nullable();
            $table->integer('metal_id');
            $table->double('price')->nullable();
            $table->double('physical_price')->nullable();
            $table->longText('images');
            $table->text('tags')->nullable();
            $table->float('percent_interval_1', 10, 0)->nullable();
            $table->float('percent_interval_2', 10, 0)->nullable();
            $table->float('percent_interval_3', 10, 0)->nullable();
            $table->float('percent_interval_4', 10, 0)->nullable();
            $table->integer('shop_position')->nullable();
            $table->string('weight', 20)->nullable();
            $table->string('purity', 20)->nullable();
            $table->string('producer', 100)->nullable();
            $table->tinyInteger('in_stock')->nullable();
            $table->tinyInteger('enabled');
            $table->string('status', 250)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
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
        Schema::dropIfExists('products');
    }
};
