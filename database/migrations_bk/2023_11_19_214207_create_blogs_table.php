<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250);
            $table->text('description');
            $table->text('image');
            $table->boolean('disabled')->default(true);
            $table->string('date', 200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('blogs');
    }
}
