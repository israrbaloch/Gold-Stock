<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who set the alert
            $table->tinyInteger('type'); // Type of alert (1 - product, 2 - metal)
            
            // Product Foreign Key
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            
            // Metal Foreign Key
            $table->unsignedBigInteger('metal_id')->nullable();
            // $table->foreign('metal_id')->references('id')->on('metals')->onDelete('cascade');
            
            $table->string('alert_type'); // Type of alert
            $table->decimal('value', 10, 2); // Price value for alert
            $table->string('frequency'); // Alert frequency
            $table->boolean('status')->default(1); // Active or Inactive
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
        Schema::dropIfExists('price_alerts');
    }
}
