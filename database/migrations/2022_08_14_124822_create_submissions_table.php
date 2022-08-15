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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('product_id');
            $table->decimal('sell_price', 12, 2);
            $table->integer('credit_count');
            $table->decimal('credit_price', 12, 2);
            $table->boolean('approved')->default(false);
            $table->boolean('paid')->default(false);
            $table->timestamps();
            $table->index('user_id');
            $table->index('product_id');
            $table->index('approved');
            $table->index('paid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submissions');
    }
};
