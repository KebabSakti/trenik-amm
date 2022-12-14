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
            $table->integer('count');
            $table->decimal('price', 12, 2);
            $table->decimal('credit', 12, 2);
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
