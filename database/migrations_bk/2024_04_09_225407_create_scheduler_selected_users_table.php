<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulerSelectedUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('scheduler_selected_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scheduler_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->boolean('sent')->default(false);
            $table->timestamps();
        });
        Schema::table('schedulers', function (Blueprint $table) {
            $table->boolean('specific_users')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('scheduler_selected_users');
        Schema::table('schedulers', function (Blueprint $table) {
            $table->dropColumn('specific_users');
        });
    }
}
