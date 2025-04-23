<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BlogsAddSlug extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('slug', 120)->after('title')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
