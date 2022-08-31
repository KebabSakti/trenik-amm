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
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('submission_id');
            $table->bigInteger('user_id');
            $table->bigInteger('department_id');
            $table->enum('status', ['approved', 'rejected'])->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->index('submission_id');
            $table->index('user_id');
            $table->index('department_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approvals');
    }
};
