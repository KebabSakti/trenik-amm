<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ApprovalRuleController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CreditSchemeController;
use App\Http\Controllers\PicApproveController;
use App\Http\Controllers\SubmissionController;

Route::group(['prefix' => 'app', 'middleware' => 'api.access'], function () { //'middleware' => 'api.access'
    Route::post('department', [DepartmentController::class, 'indexJSON']);
    Route::post('jabatan', [JabatanController::class, 'indexJSON']);
    Route::post('grade', [GradeController::class, 'indexJSON']);
    Route::post('product', [ProductController::class, 'indexJSON']);
    Route::post('credit_scheme', [CreditSchemeController::class, 'indexJSON']);
    Route::post('rule', [ApprovalRuleController::class, 'indexJSON']);
    Route::post('setting', [SettingController::class, 'indexJSON']);
    Route::post('barang', [BarangController::class, 'indexJSON']);
    Route::post('employee', [EmployeeController::class, 'indexJSON']);
    Route::post('submission', [SubmissionController::class, 'indexJSON']);
    Route::post('picapprove', [PicApproveController::class, 'indexJSON']);
});
