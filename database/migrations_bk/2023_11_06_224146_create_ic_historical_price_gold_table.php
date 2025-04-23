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
        Schema::create('ic_historical_price_gold', function (Blueprint $table) {
            $table->integer('id', true);
            $table->float('current_value', 10, 0)->nullable();
            $table->float('change_value', 10, 0)->nullable();
            $table->float('change_percent', 10, 0)->nullable();
            $table->float('ask', 10, 0)->nullable();
            $table->float('bid', 10, 0)->nullable();
            $table->float('daily_lowest', 10, 0)->nullable();
            $table->float('daily_highest', 10, 0)->nullable();
            $table->dateTime('value_date')->nullable();
            $table->text('current_type')->nullable();
            $table->bigInteger('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ic_historical_price_gold');
    }
};
