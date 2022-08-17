<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WizardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;

Route::get('/', function () {
    return redirect('login');
});

Route::group(['prefix' => 'wizard'], function () {
    Route::get('/', [WizardController::class, 'access']);
    Route::post('authenticate', [WizardController::class, 'authenticate']);

    Route::middleware('wizard.access')->group(function () {
        Route::get('{session}', [WizardController::class, 'add']);
        Route::post('{session}', [WizardController::class, 'store']);
    });
});

Route::group(['prefix' => 'login'], function () {
    Route::get('/', [AuthController::class, 'login']);
    Route::post('authenticate', [AuthController::class, 'authenticate']);
    //
    Route::group(['middleware' => 'auth'], function () {
        Route::get('unauthenticate', [AuthController::class, 'unauthenticate']);
    });
});

Route::group(['prefix' => 'app', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index']);
    });

    Route::group(['prefix' => 'department'], function () {
        Route::get('/', [DepartmentController::class, 'index']);
        Route::post('/', [DepartmentController::class, 'store']);
        Route::put('/', [DepartmentController::class, 'update']);
        Route::delete('/', [DepartmentController::class, 'delete']);
    });
});
