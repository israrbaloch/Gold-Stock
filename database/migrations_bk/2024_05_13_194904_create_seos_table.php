<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSEOSTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('seos', function (Blueprint $table) {
            $table->id();
            $table->string('uri');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::table('keywords', function (Blueprint $table) {
            $table->foreignId('seo_id')->after('id')->constrained()->onDelete('cascade');
            $table->dropColumn('uri');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('keywords', function (Blueprint $table) {
            $table->dropForeign(['seo_id']);
            $table->dropColumn('seo_id');
            $table->string('uri');
        });
        Schema::dropIfExists('seos');
    }
}
