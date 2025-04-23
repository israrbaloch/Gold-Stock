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
        Schema::create('home_news', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', 250)->nullable();
            $table->text('description')->nullable();
            $table->text('url');
            $table->text('image')->nullable();
            $table->string('author', 250)->nullable();
            $table->string('date', 200)->nullable();
            $table->bigInteger('timestamp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_news');
    }
};
