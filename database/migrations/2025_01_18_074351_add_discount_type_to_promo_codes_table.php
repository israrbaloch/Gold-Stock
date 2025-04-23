<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountTypeToPromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->enum('discount_type', ['percentage', 'flat'])->default('percentage')->after('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->dropColumn('discount_type');
        });
    }
}
