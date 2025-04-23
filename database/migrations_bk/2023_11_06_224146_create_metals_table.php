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
        Schema::create('metals', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 250);
            $table->string('code', 10);
            $table->float('buy_premium', 10, 0)->nullable();
            $table->float('bprofit', 10, 0)->nullable();
            $table->float('sell_premium', 10, 0)->nullable();
            $table->float('sprofit', 10, 0)->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('metals');
    }
};
