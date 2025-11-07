<?php

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

// Admin Route

// User Route
Route::middleware('UserAuthCheck')->group(function () {

    Route::match(['get', 'post'], '/Dashbord-User', [UserController::class, 'User_Dashboard'])->name('user.Dashboard');
    Route::match(['get', 'post'], '/Logout-User', [UserController::class, 'User_Logout'])->name('user.logout');
    Route::match(['get', 'post'], '/User-Profile', [UserController::class, 'User_Profile'])->name('user.profile');

    // Attendance Route
    Route::match(['get', 'post'], '/Attendance-CheckIn', [AttendanceController::class, "Attendance_Check_IN"])->name('attendance.checkin');
    Route::match(['get', 'post'], '/Attendance-CheckOut', [AttendanceController::class, "Attendance_Check_OUT"])->name('attendance.checkout');

    // Change Chack IN and Chack OUT Time
    Route::match(['get', 'post'], '/CheckIn-Time-Change', [AttendanceController::class, 'Check_IN_Time_Change'])->name('checkin.time.change');
    Route::match(['get', 'post'], '/CheckOut-Time-Change', [AttendanceController::class, 'Check_OUT_Time_Change'])->name('checkout.time.change');
    Route::match(['get', 'post'], '/Check-Delete/{checkid}', [AttendanceController::class, 'Check_Data_Delete'])->name('check.data.delete');

    // HR Routes
    Route::match(['get', 'post'], '/Employees', [UserController::class, 'HR_get_Employee_Data'])->name('hrget.employee.data');
    Route::match(['get', 'post'], '/Employees/{id}', [UserController::class, 'HR_get_Employee_Data_id'])->name('hrget.employee.data.id');
});
