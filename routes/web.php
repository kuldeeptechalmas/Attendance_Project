<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

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

// Main Route
Route::redirect('/', '/Login',);
Route::match(['get', 'post'], "/Login", [MainController::class, 'Login_User'])->name("login");
Route::match(['get', 'post'], "/Registration", [MainController::class, 'Registration_User'])->name("registration");
Route::get('/Logout-User', [MainController::class, 'User_Logout'])->name('user.logout');
Route::match(['get', 'post'], '/Forget-Email-Check', [MainController::class, 'User_Forgot_Email_Check'])->name('user.forget.email.check');
Route::match(['get', 'post'], '/Forget-Password', [MainController::class, 'User_Forgot_Password'])->name('user.forget.password');

Route::middleware('AuthCheck')->group(function () {
    Route::get('/Dashbord-User', [UserController::class, 'User_Dashboard'])->name('user.Dashboard');
    Route::match(['get', 'post'], '/User-Profile', [UserController::class, 'User_Profile'])->name('user.profile');
});

Route::middleware('SuperAdminAuthCheck')->group(function () {
    Route::get('/SuperAdmin-Admin', [AdminController::class, 'SuperAdmin_Show_Admin'])->name('superadmin.show.admin');
    Route::get('/SuperAdmin-Admin/{adminid}', [AdminController::class, 'SuperAdmin_Find_Admin'])->name('superadmin.find.admin');
});

// Admin Route
Route::middleware('AdminAuthCheck')->group(function () {

    Route::get('/Admin-Dashbord', [AdminController::class, 'Admin_Dashborad'])->name('admin.dashbord');
    Route::match(['get', 'post'], '/Admin-Profile', [AdminController::class, 'Admin_Profile'])->name('admin.profile');

    // Employee Manage
    Route::match(['get', 'post'], '/Admin-Employee', [AdminController::class, 'Admin_Employee_Manage'])->name('admin.employee.manage');
    Route::get('/Admin-Employee/{id}', [AdminController::class, 'Admin_Find_Employee'])->name('admin.find.employee');
    Route::post('/Admin-Employee-Modify', [AdminController::class, 'Admin_Modify_Employee'])->name('admin.modify.employee');

    // HR Manage
    Route::match(['get', 'post'], '/Admin-HR', [AdminController::class, 'Admin_Hr_Manage'])->name('admin.hr.manage');
    Route::get('/Admin-HR/{id}', [AdminController::class, 'Admin_Find_Hr'])->name('admin.find.hr');
    Route::post('/Admin-HR-Modify', [AdminController::class, 'Admin_Modify_Hr'])->name('admin.modify.hr');

    // Admin Add Employee,user
    Route::match(['get', 'post'], '/Admin-Add', [AdminController::class, 'Admin_Add_Employee_HR'])->name('admin.add');
});



// HR Routes
Route::middleware("HRAuthCheck")->group(function () {
    Route::match(['get', 'post'], '/Employees', [UserController::class, 'HR_get_Employee_Data'])->name('hrget.employee.data');
    Route::match(['get', 'post'], '/Employees/{id}', [UserController::class, 'HR_Modify_Employee_Details'])->name('hrget.employee.data.id');
    Route::match(['get', 'post'], '/Employees-Modify', [UserController::class, 'Employee_Data_Modify'])->name('employee.data.modify');
});

// User Route
Route::middleware('UserAuthCheck')->group(function () {

    // Attendance Route
    Route::match(['get', 'post'], '/Attendance-Employee', [AttendanceController::class, 'Add_Attendance_Employee'])->name('add.attendance.employee');

    Route::match(['get', 'post'], '/Attendance-Delete/{attendkid}', [AttendanceController::class, 'Today_Attandance_Delete'])->name('attendance.today.delete');
    Route::match(['get', 'post'], '/Month-Attendance/{empid}', [UserController::class, 'Monthly_Data_For_Employee_Find'])->name('month.attendance');
    Route::match(['get', 'post'], '/Month-AttendanceData/{month}/{year}', [UserController::class, 'Monthly_Data_For_Employee_Show'])->name('month.attendance.show');

    // Change Chack IN and Chack OUT Time
    Route::match(['get', 'post'], '/CheckIn-Time-Change', [AttendanceController::class, 'Check_IN_Time_Change'])->name('checkin.time.change');
    Route::match(['get', 'post'], '/CheckOut-Time-Change', [AttendanceController::class, 'Check_OUT_Time_Change'])->name('checkout.time.change');
    Route::match(['get', 'post'], '/Check-Delete', [AttendanceController::class, 'Check_Data_Delete'])->name('check.data.delete');

    // PDF
    Route::match(['get', 'post'], '/Pdf', [MainController::class, 'PDF_For_Employee'])->name('pdf.manage');

    // Teams
    Route::match(['get', 'post'], '/Teams', [UserController::class, 'Teams'])->name('teams');
});
