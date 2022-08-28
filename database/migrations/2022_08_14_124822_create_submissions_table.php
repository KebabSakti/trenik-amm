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
            $table->bigInteger('credit_scheme_id');
            $table->enum('submission_status', ['pending', 'approved', 'rejected']);
            $table->enum('payment_status', ['unpaid', 'progress', 'paid']);
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
