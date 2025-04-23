<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionToTemplates extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('mail_templates', function (Blueprint $table) {
            $table->enum('subscription', ['news', 'blogs', 'promo'])->nullable()->after('template');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('mail_templates', function (Blueprint $table) {
            $table->dropColumn('subscription');
        });
    }
}
