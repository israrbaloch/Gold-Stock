<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingPrices extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('shipping_options', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('free_from', 10, 2)->default(0);
            $table->boolean('show_address')->default(false);
        });

        // Set the current shipping option 'delivery' to 20.00 and free from 100.00
        DB::table('shipping_options')->where('name', 'Delivery')->update([
            'price' => 20.00,
            'free_from' => 100.00
        ]);

        // Set the current shipping option 'pickup' show_address to true
        DB::table('shipping_options')->where('name', 'Pick up in store')->update([
            'show_address' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('shipping_options', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('free_from');
            $table->dropColumn('show_address');
        });
    }
}
