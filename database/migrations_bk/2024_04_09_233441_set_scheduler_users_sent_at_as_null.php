<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetSchedulerUsersSentAtAsNull extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('scheduler_users', function (Blueprint $table) {
            $table->dateTime('sent_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('scheduler_users', function (Blueprint $table) {
            $table->dateTime('sent_at')->change();
        });
    }
}
