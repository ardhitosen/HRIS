<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Auth;

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

Route::redirect('/', '/employee');
Auth::routes();

Route::controller(AdminController::class)->prefix('admins/')->group(function(){
    Route::view('/', 'backend.index')->name('login');
    Route::post('/loginProcess','loginProcess')->name('loginProcess');
});

Route::controller(AdminController::class)->prefix('admins/')->middleware('auth:admin')->group(function(){
    Route::get('/logoutProcess', 'logoutProcess')->name('logoutProcess');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    
    Route::get('employee/', 'employee')->name('employee');
    Route::get('/employee/detail/personal/{id}', 'employeeDetail')->name('employeeDetail');
    Route::get('/employee/detail/employment/{id}', 'employeeEmployment')->name('employeeEmployment');
    Route::get('/employee/detail/transferlog/{id}', 'employeeTransferLog')->name('employeeTransferLog');
    Route::get('/employee/resign/{id}', 'resign')->name('resign');
    Route::post('/employee/edit/{id}', 'editemployee')->name('edit');
    Route::post('/employee/edit/changepp/{id}', 'changeProfilePic')->name('changeProfilePic');
    Route::post('/employee/transfer/{id}', 'transferEmployee')->name('transfer');
    Route::post('/employee/addemployee', 'addEmployee')->name('addEmployee');
    
    Route::get('/attendance', 'attendance')->name('attendance');
    Route::get('/attendance/clockin/{id}', 'clockIn')->name('clockin');   
    Route::get('/attendance/clockout/{id}', 'clockOut')->name('clockout');
    Route::post('/attendance/generate', 'generateAttendance')->name('generateAttendance');
    Route::post('/attendance/edit/{id}', 'attendanceEdit')->name('attendanceEdit');
    Route::view('/attendance/history', 'backend.timeManagement.attendanceHistory')->name('attendanceHistory');
    
    Route::get('/calendar', 'calendar')->name('calendar');
    Route::post('/calendar/addevent', 'addEvent')->name('addEvent');
    Route::post('/calendar/editevent/{id}', 'editEvent')->name('editEvent');
    Route::delete('/calendar/deleteevent/{id}', 'deleteEvent')->name('deleteEvent');
    
    Route::get('/overtime', 'overtime')->name('overtime');
    Route::post('/overtime/assign', 'overtimeAssign')->name('overtimeAssign');
    Route::get('/overtime/{status}/{id}', 'overtimeStatusChange')->name('overtimeStatusChange');
    
    Route::get('/scheduler', 'scheduler')->name('scheduler');
    Route::post('/scheduler/assign', 'assignScheduler')->name('assignScheduler');
    
    Route::get('/timeoff', 'timeoff')->name('timeoff');
    Route::post('/timeoff/assign', 'timeoffAssign')->name('assigntimeoff');
    Route::get('/timeoff/status/{status}/{id}', 'statusChange')->name('statusChange');
    
    Route::get('/announcement', 'announcement')->name('announcement');
    Route::post('/addannouncement', 'create_announcement')->name('createAnnouncement');
    Route::post('/editannouncement/{id}', 'editannouncement')->name('editAnnouncement');
    Route::delete('/deleteannouncement/{id}', 'deleteannouncement')->name('deleteAnnouncement');
    
    Route::get('/payroll', 'payroll')->name('payroll');
    
    Route::get('/reimbursement', 'reimbursement')->name('reimbursement');
    Route::post('/reimbursement/create', 'createReimbursement')->name('reimbursementCreate');
    Route::post('/reimbursement/status/revision/{id}', 'reimburseRevision')->name('reimburseRevision');
    Route::get('/reimbursement/status/{status}/{id}', 'reimbursementAction')->name('reimburseAction');
    

});

Route::controller(EmployeeController::class)->prefix('employee/')->group(function(){
    Route::view('/', 'frontend.index')->name('index_frontend');
    Route::post('/login', 'login')->name('frontend_login');
});

Route::controller(EmployeeController::class)->prefix('employee/')->middleware('auth.employee:employee')->group(function(){
    Route::get('/dashboard', 'dashboard')->name('frontend_dashboard');
    Route::get('/attendance', 'attendance')->name('frontend_attendance');
    Route::post('/attendance/clockin', 'clockIn')->name('frontend_clockin');
    Route::post('/attendance/clockout', 'clockOut')->name('frontend_clockout');

    Route::get('/timeoff', 'timeoff')->name('frontend_timeoff');
    Route::post('/timeoff/add', 'timeoffAdd')->name('frontend_timeoff_add');

    Route::get('/overtime', 'overtime')->name('frontend_overtime');
    Route::post('/overtime/add', 'overtimeadd')->name('frontend_overtime_add');

    Route::get('/announcement', 'announcement')->name('frontend_announcement');
    
    Route::get('/profile', 'show_profile')->name('frontend_profile');
    
    Route::get('/reimbursement', 'reimbursement')->name('frontend_reimbursement');
    Route::post('/reimbursement/create', 'reimbursement_create')->name('frontend_reimbursement_create');

    Route::get('/logout', 'logout')->name('frontend_logout');
});
