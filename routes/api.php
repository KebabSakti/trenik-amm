<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;

Route::group(['prefix' => 'app', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'department'], function () {
        Route::get('/', [DepartmentController::class, 'indexJSON']);
    });
});
