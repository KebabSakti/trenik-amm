<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TncController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\WizardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PicApproveController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ApprovalRuleController;
use App\Http\Controllers\CreditSchemeController;

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

    Route::resource('company', CompanyController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::resource('grade', GradeController::class);
    Route::resource('product', ProductController::class);
    Route::resource('credit_scheme', CreditSchemeController::class);
    Route::resource('rule', ApprovalRuleController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('employee', EmployeeController::class);
    Route::resource('submission', SubmissionController::class);
    Route::resource('picapprove', PicApproveController::class);

    Route::group(['prefix' => 'export'], function () {
        //pdf
        Route::get('submission_detail/{id}', [ExportController::class, 'submission_detail'])->name('submission_detail');
        Route::post('submission_recap', [ExportController::class, 'submission_recap'])->name('submission_recap');
        Route::get('pdf/employee', [ExportController::class, 'pdf_employee'])->name('pdf_employee');

        //excel
        Route::get('excel/employee', [ExportController::class, 'excel_employee'])->name('excel_employee');
        Route::post('excel/submission_recap', [ExportController::class, 'excel_submission_recap'])->name('excel_submission_recap');
    });
});

//debug
Route::get('debug/{param}', [DebugController::class, 'index'])->name('debug_index');
