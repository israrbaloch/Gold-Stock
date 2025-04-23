<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceNameBySubject extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('mail_templates', function (Blueprint $table) {
            $table->renameColumn('name', 'subject');
        });
        Schema::table('schedulers', function (Blueprint $table) {
            // remove the name column
            $table->dropColumn('subject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('mail_templates', function (Blueprint $table) {
            $table->renameColumn('subject', 'name');
        });
        Schema::table('schedulers', function (Blueprint $table) {
            $table->string('subject');
        });
        // set mail_templates.name to scheduler.subject
        DB::table('schedulers')
            ->join('mail_templates', 'schedulers.template_id', '=', 'mail_templates.id')
            ->update([
                'schedulers.subject' => DB::raw('mail_templates.name'),
            ]);
    }
}
