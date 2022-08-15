<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('login');
});

Route::group(['prefix' => 'login'], function () {
    Route::get('/', [AuthController::class, 'login']);
    Route::post('/authenticate', [AuthController::class, 'authenticate']);
    Route::get('/unatuhenticate', [AuthController::class, 'unatuhenticate']);
});
