<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToScheduler extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('schedulers', function (Blueprint $table) {
            // remove specific_users boolean
            $table->dropColumn('specific_users');

            // add type column
            $table->enum('type', ['specific', 'business', 'all'])->default('all')->after('status');
        });

        // the current existing ones are specific users
        DB::table('schedulers')->update(['type' => 'specific']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('schedulers', function (Blueprint $table) {
            $table->boolean('specific_users')->default(false);
        });

        // Set specific_users to true for rows with type 'specific'
        DB::table('schedulers')->where('type', 'specific')->update(['specific_users' => true]);

        Schema::table('schedulers', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
