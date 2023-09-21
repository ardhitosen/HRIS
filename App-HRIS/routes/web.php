<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/admins/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::post('/admins/loginProcess', [AdminController::class, 'loginProcess'])->name('loginProcess');
Route::get('/admins/logoutProcess', [AdminController::class, 'logoutProcess'])->name('logoutProcess');

Route::get('/admins/employee', [AdminController::class, 'employee'])->name('employee');
Route::get('/admins/employee/detail/personal/{id}', [AdminController::class, 'employeeDetail'])->name('employeeDetail');
Route::get('/admins/employee/detail/employment/{id}', [AdminController::class, 'employeeEmployment'])->name('employeeEmployment');
Route::get('/admins/employee/detail/transferlog/{id}', [AdminController::class, 'employeeTransferLog'])->name('employeeTransferLog');
Route::get('/admins/employee/resign/{id}', [AdminController::class, 'resign'])->name('resign');
Route::post('/admins/employee/edit/{id}', [AdminController::class, 'editemployee'])->name('edit');
Route::post('/admins/employee/transfer/{id}', [AdminController::class, 'transferEmployee'])->name('transfer');
Route::post('/admins/addemployee', [AdminController::class, 'addEmployee'])->name('addEmployee');

Route::get('/admins/attendance', [AdminController::class, 'attendance'])->name('attendance');
Route::get('/admins/attendance/clockin/{id}', [AdminController::class, 'clockIn'])->name('clockin');   
Route::get('/admins/attendance/clockout/{id}', [AdminController::class, 'clockOut'])->name('clockout');
Route::post('/admins/attendance/generate', [AdminController::class, 'generateAttendance'])->name('generateAttendance');
Route::post('/admins/attendance/edit/{id}', [AdminController::class, 'attendanceEdit'])->name('attendanceEdit');

Route::get('/admins/calendar', [AdminController::class, 'calendar'])->name('calendar');
Route::post('/admins/calendar/addevent', [AdminController::class, 'addEvent'])->name('addEvent');

Route::get('/admins/overtime', [AdminController::class, 'overtime'])->name('overtime');
Route::post('/admins/overtime/assign', [AdminController::class, 'overtimeAssign'])->name('overtimeAssign');
Route::get('/admins/overtime/{status}/{id}', [AdminController::class, 'overtimeStatusChange'])->name('overtimeStatusChange');

Route::get('/admins/scheduler', [AdminController::class, 'scheduler'])->name('scheduler');
Route::post('/admins/scheduler/assign', [AdminController::class, 'assignScheduler'])->name('assignScheduler');

Route::get('/admins/timeoff', [AdminController::class, 'timeoff'])->name('timeoff');
Route::post('/admins/timeoff/assign', [AdminController::class, 'timeoffAssign'])->name('assigntimeoff');
Route::get('/admins/timeoff/status/{status}/{id}', [AdminController::class, 'statusChange'])->name('statusChange');

Route::get('/admins/announcement', [AdminController::class, 'announcement'])->name('announcement');
Route::post('/admins/addannouncement', [AdminController::class, 'create_announcement'])->name('createAnnouncement');
Route::post('/admins/editannouncement/{id}', [AdminController::class, 'editannouncement'])->name('editAnnouncement');
Route::delete('/admins/deleteannouncement/{id}', [AdminController::class, 'deleteannouncement'])->name('deleteAnnouncement');

Route::get('/admins/payroll', [AdminController::class, 'payroll'])->name('payroll');

Route::get('/admins/reimbursement', [AdminController::class, 'reimbursement'])->name('reimbursement');
Route::post('/admins/reimbursement/create', [AdminController::class, 'createReimbursement'])->name('reimbursementCreate');
Route::post('/admins/reimbursement/status/revision/{id}', [AdminController::class, 'reimburseRevision'])->name('reimburseRevision');
Route::get('/admins/reimbursement/status/{status}/{id}', [AdminController::class, 'reimbursementAction'])->name('reimburseAction');



Route::get('/employee', function () {
    return view('frontend.index');
})->name('index_frontend');

Route::controller(EmployeeController::class)->group(function(){
    Route::post('/employee/login', 'login')->name('frontend_login');
    Route::get('/employee/dashboard', 'dashboard')->name('frontend_dashboard');
    Route::get('/employee/attendance', 'attendance')->name('frontend_attendance');
    Route::post('/employee/attendance/clockin', 'clockIn')->name('frontend_clockin');
    Route::post('/employee/attendance/clockout', 'clockOut')->name('frontend_clockout');
    Route::get('/employee/timeoff', 'timeoff')->name('frontend_timeoff');
    Route::post('/employee/timeoff/add', 'timeoffAdd')->name('frontend_timeoff_add');
    Route::get('/employee/overtime', 'overtime')->name('frontend_overtime');
    Route::post('/employee/overtime/add', 'overtimeadd')->name('frontend_overtime_add');
    Route::get('/employee/announcement', 'announcement')->name('frontend_announcement');
    Route::get('/employee/logout', 'logout')->name('frontend_logout');
});