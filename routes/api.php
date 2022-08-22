<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApprovalRuleController;
use App\Http\Controllers\ApprovalRuleDetailController;
use App\Http\Controllers\CreditSchemeController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SettingController;

Route::group(['prefix' => 'app', 'middleware' => 'api.access'], function () {
    Route::post('department', [DepartmentController::class, 'indexJSON']);
    Route::post('jabatan', [JabatanController::class, 'indexJSON']);
    Route::post('grade', [GradeController::class, 'indexJSON']);
    Route::post('product', [ProductController::class, 'indexJSON']);
    Route::post('credit_scheme', [CreditSchemeController::class, 'indexJSON']);
    Route::post('rule', [ApprovalRuleController::class, 'indexJSON']);
    Route::post('rule_detail', [ApprovalRuleDetailController::class, 'indexJSON']);
    Route::post('setting', [SettingController::class, 'indexJSON']);
});
