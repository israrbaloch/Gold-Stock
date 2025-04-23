<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('schedulers', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->foreignId('template_id')->constrained('mail_templates');
            $table->dateTime('scheduled_at');
            
            $table->enum('status', ['pending', 'sent', 'failed', 'in progress'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('schedulers');
    }
}
