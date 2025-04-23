<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricalTables extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        // XAU/USD - Gold
        Schema::create('ht_gold_1d', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_gold_1h', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_gold_15m', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_gold_5m', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_gold_1m', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });

        // XAG/USD - Silver
        Schema::create('ht_silver_1d', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_silver_1h', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_silver_15m', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_silver_5m', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_silver_1m', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });

        // XPT/USD - Platinum
        Schema::create('ht_platinum_1d', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_platinum_1h', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_platinum_15m', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_platinum_5m', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_platinum_1m', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });

        // XPD/USD - Palladium
        Schema::create('ht_palladium_1d', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_palladium_1h', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_palladium_15m', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_palladium_5m', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
        Schema::create('ht_palladium_1m', function (Blueprint $table) {
            $table->bigInteger('timestamp_id')->primary();
            $table->index('timestamp_id');
            $table->decimal('open', 15, 2);
            $table->decimal('high', 15, 2);
            $table->decimal('low', 15, 2);
            $table->decimal('close', 15, 2);
            $table->boolean('market_open')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('ht_gold_1d');
        Schema::dropIfExists('ht_gold_1h');
        Schema::dropIfExists('ht_gold_15m');
        Schema::dropIfExists('ht_gold_5m');
        Schema::dropIfExists('ht_gold_1m');

        Schema::dropIfExists('ht_silver_1d');
        Schema::dropIfExists('ht_silver_1h');
        Schema::dropIfExists('ht_silver_15m');
        Schema::dropIfExists('ht_silver_5m');
        Schema::dropIfExists('ht_silver_1m');

        Schema::dropIfExists('ht_platinum_1d');
        Schema::dropIfExists('ht_platinum_1h');
        Schema::dropIfExists('ht_platinum_15m');
        Schema::dropIfExists('ht_platinum_5m');
        Schema::dropIfExists('ht_platinum_1m');

        Schema::dropIfExists('ht_palladium_1d');
        Schema::dropIfExists('ht_palladium_1h');
        Schema::dropIfExists('ht_palladium_15m');
        Schema::dropIfExists('ht_palladium_5m');
        Schema::dropIfExists('ht_palladium_1m');
    }
}
