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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('department_id');
            $table->bigInteger('position_id');
            $table->bigInteger('grade_id');
            $table->string('employee_name');
            $table->string('nik');
            $table->string('phone');
            $table->string('ktp');
            $table->timestamps();
            $table->index('user_id');
            $table->index('department_id');
            $table->index('grade_id');
            $table->index('employee_name');
            $table->index('nik');
            $table->index('phone');
            $table->index('ktp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
