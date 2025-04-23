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
        Schema::create('slider_items', function (Blueprint $table) {
            $table->increments('id');
            $table->text('link')->nullable();
            $table->text('image')->nullable();
            $table->text('image_css')->nullable();
            $table->text('image_link')->nullable();
            $table->text('text')->nullable();
            $table->text('text_css')->nullable();
            $table->text('text_link')->nullable();
            $table->text('button')->nullable();
            $table->text('button_css')->nullable();
            $table->text('button_link')->nullable();
            $table->string('slider_name', 250)->nullable();
            $table->tinyInteger('is_desktop')->nullable();
            $table->tinyInteger('is_mobile')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slider_items');
    }
};
