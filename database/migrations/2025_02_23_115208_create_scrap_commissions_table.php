<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrap_commissions', function (Blueprint $table) {
            $table->id();
            $table->decimal('gold', 8, 2)->default(0);
            $table->decimal('silver', 8, 2)->default(0);
            $table->decimal('platinum', 8, 2)->default(0);
            $table->decimal('palladium', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scrap_commissions');
    }
}
