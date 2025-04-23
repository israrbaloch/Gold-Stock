<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceUsersSubscribedByNewsBlogsNotifications extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('news_subscribed')->default(true)->after('subscribed');
            $table->boolean('blogs_subscribed')->default(true)->after('news_subscribed');
            $table->boolean('promo_subscribed')->default(true)->after('blogs_subscribed');
            // $table->dropColumn('subscribed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('news_subscribed');
            $table->dropColumn('blogs_subscribed');
            $table->dropColumn('promo_subscribed');
            // $table->boolean('subscribed')->default(true)->after('email');
        });
    }
}
