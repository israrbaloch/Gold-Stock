<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailTemplatePropertiesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mail_template_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mail_template_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type');
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('mail_template_properties');
        Schema::dropIfExists('mail_template_requirements');
    }
}
