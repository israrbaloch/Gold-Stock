<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromoCodeDiscountToProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_orders', function (Blueprint $table) {
            $table->decimal('promo_code_discount', 10, 2)->default(0)->after('promo_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_orders', function (Blueprint $table) {
            $table->dropColumn('promo_code_discount');
        });
    }
}
