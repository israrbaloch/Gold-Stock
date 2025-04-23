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
        Schema::create('ic_historical_rate', function (Blueprint $table) {
            $table->integer('id', true);
            $table->float('us_rate', 10, 0);
            $table->float('cad_rate', 10, 0);
            $table->float('eur_rate', 10, 0);
            $table->float('cad_rate_inverse', 10, 0);
            $table->float('eur_rate_inverse', 10, 0);
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
        Schema::dropIfExists('ic_historical_rate');
    }
};
