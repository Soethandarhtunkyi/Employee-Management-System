<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Payroll\PayrollController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Schedule\ScheduleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Setting\MstCalendarController;
use App\Http\Controllers\Attendance\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Employee list resource route
Route::prefix('employee')->middleware('auth')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employee-showLists');
    Route::get('download', [EmployeeController::class, 'downloadCSV'])->name('employees-download');
    Route::get('upload', [EmployeeController::class, 'showUpload'])->name('employees-upload');
    Route::post('submit', [EmployeeController::class, 'submitUpload'])->name('employees-submit');
    Route::get('/{id}', [EmployeeController::class, 'showEmployeeDetailForm'])->name('employees-show');
    Route::get('create/get', [EmployeeController::class, 'create'])->name('employees-create');
    Route::post('add', [EmployeeController::class, 'submitEmployeeForm'])->name('employees-store');
    Route::get('/{id}/edit', [EmployeeController::class, 'showEmployeeEditForm'])->name('employees-edit');
    Route::patch('/{id}', [EmployeeController::class, 'submitEmployeeEditForm'])->name('employees-update');
    Route::delete('/{id}', [EmployeeController::class, 'deleteEmployee'])->name('employees-delete');
});

// Dashboard route to show chart
Route::get('/dashboard', [EmployeeController::class, 'graph'])->name('graph-dashBoard')->middleware('auth');

Route::get('/', function () {
    return redirect()->route('graph-dashBoard');
});

// Attendance Routes
Route::prefix('attendance')->middleware('auth')->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('attendances-index');
    Route::post('store', [AttendanceController::class, 'store'])->name('attendances-store');
    Route::get('update', [AttendanceController::class, 'update'])->name('attendances-update');
    Route::post('customleave', [AttendanceController::class, 'customLeave'])
        ->name('attendances-customLeave');
});

// Payroll Routes
Route::prefix('payroll')->middleware('auth')->group(function () {
    Route::get('/', [PayrollController::class, 'index'])->name('payrolls-index');
    Route::get('{employee}', [PayrollController::class, 'calculate'])->name('payrolls-calculate');
    Route::get('{finalsalary}/sendpayrollmail', [PayrollController::class, 'sendPayrollMail'])
        ->name('payrolls-sendPayrollMail');
    Route::get('{employee}/recalculate', [PayrollController::class, 'recalculate'])->name('payrolls-recalculate');
    Route::get('{employee}/editview', [PayrollController::class, 'showEditView'])
        ->name('payroll-showEditView');
    Route::patch('{employee}', [PayrollController::class, 'updatePayroll'])
        ->name('payrolls-updatePayroll');
});

// Project Management Routes
Route::prefix('project')->middleware('auth')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('projects-index');
    Route::get('createview', [ProjectController::class, 'showCreateView'])
        ->name('projects-showCreateView');
    Route::post('store', [ProjectController::class, 'postCreate'])
        ->name('projects-postCreate');
    Route::get('{project}/members', [ProjectController::class, 'getMembers'])
        ->name('projects-getMembers');
    Route::get('{project}/editview', [ProjectController::class, 'showEditView'])
        ->name('projects-showEditView');
    Route::get('{project}/{id}/membertoogle', [ProjectController::class, 'memberToogle'])
        ->name('projects-memberToogle');
    Route::patch('{project}', [ProjectController::class, 'updateProject'])
        ->name('projects-updateProject');
    Route::delete('{project}', [ProjectController::class, 'deleteProject'])
        ->name('projects-deleteProject');
    Route::get('{project}', [ProjectController::class, 'showDetail'])
        ->name('projects-showDetail');
    Route::get('{project}/schedulecreateview', [ScheduleController::class, 'scheduleCreateView'])
        ->name('projects-scheduleCreateView');
    Route::post('{project}/storeschedule', [ScheduleController::class, 'storeSchedule'])
        ->name('projects-storeSchedule');
    Route::get('schedule/{schedule}', [ScheduleController::class, 'showSchedule'])
        ->name('projects-showSchedule');
    Route::get('schedule/{schedule}/downloadfile', [ScheduleController::class, 'downloadFile'])
        ->name('projects-downloadFile');
    Route::get('schedule/{schedule}/updatestatus', [ScheduleController::class, 'updateStatus'])
        ->name('projects-updateStatus');
});

// Setting Routes
Route::prefix('setting')->middleware('auth')->group(function () {
    Route::get('/', [MstCalendarController::class, 'showUpload'])->name('calendar-upload');
    Route::post('/', [MstCalendarController::class, 'submitUpload'])->name('calendar-submit');
});

// Custom auth routes
Route::group(['middleware' => ['guest']], function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('post-login', [AuthController::class, 'postLogin'])->name('login-post');
    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])
        ->name('forget-password-get');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])
        ->name('forget-password-post');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])
        ->name('reset-password-get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])
        ->name('reset-password-post');
});
Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
