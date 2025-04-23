<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPercentIntervalsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('percent_interval_cc_1', 8, 2)->nullable()->after('percent_interval_4');
            $table->decimal('percent_interval_cc_2', 8, 2)->nullable()->after('percent_interval_cc_1');
            $table->decimal('percent_interval_cc_3', 8, 2)->nullable()->after('percent_interval_cc_2');
            $table->decimal('percent_interval_cc_4', 8, 2)->nullable()->after('percent_interval_cc_3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('percent_interval_cc_1');
            $table->dropColumn('percent_interval_cc_2');
            $table->dropColumn('percent_interval_cc_3');
            $table->dropColumn('percent_interval_cc_4');
        });
    }
}
