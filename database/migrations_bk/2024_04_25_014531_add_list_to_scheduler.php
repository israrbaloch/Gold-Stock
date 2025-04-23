<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddListToScheduler extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('schedulers', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_id')->nullable()->after('type');
            $table->foreign('subscription_id')->references('id')->on('subscription_lists');
        });

        // add 'list' option to type enum column
        DB::statement("ALTER TABLE schedulers MODIFY COLUMN type ENUM('specific', 'business', 'all', 'list')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('schedulers', function (Blueprint $table) {
            $table->dropForeign(['subscription_id']);
            $table->dropColumn('subscription_id');
        });

        // remove 'list' option from type enum column
        DB::statement("ALTER TABLE schedulers MODIFY COLUMN type ENUM('specific', 'business', 'all')");
    }
}
