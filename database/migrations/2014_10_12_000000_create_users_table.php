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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id');
            $table->enum('role', ['admin', 'pic', 'user'])->default('user');
            $table->string('email')->unique();
            $table->string('password');
            $table->text('api');
            $table->rememberToken();
            $table->timestamps();
            $table->index('company_id');
            $table->index('role');
            $table->index('email');
            $table->index('api');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
