<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulerUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('scheduler_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scheduler_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->dateTime('sent_at');
            
            $table->enum('status', ['pending', 'sent', 'failed', 'in progress'])->default('pending');
            $table->integer('attempts')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('scheduler_users');
    }
}
