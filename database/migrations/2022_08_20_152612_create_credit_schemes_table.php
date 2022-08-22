<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_schemes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->decimal('price_1x', 12, 2);
            $table->decimal('credit_1x', 12, 2);
            $table->decimal('price_3x', 12, 2);
            $table->decimal('credit_3x', 12, 2);
            $table->decimal('price_6x', 12, 2);
            $table->decimal('credit_6x', 12, 2);
            $table->decimal('price_9x', 12, 2);
            $table->decimal('credit_9x', 12, 2);
            $table->decimal('price_12x', 12, 2);
            $table->decimal('credit_12x', 12, 2);
            $table->timestamps();
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_schemes');
    }
};
