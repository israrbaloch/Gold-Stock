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
        Schema::create('translations', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('table_name');
            $table->string('column_name');
            $table->unsignedInteger('foreign_key');
            $table->string('locale');
            $table->text('value');
            $table->timestamps();

            $table->unique(['table_name', 'column_name', 'foreign_key', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
};
