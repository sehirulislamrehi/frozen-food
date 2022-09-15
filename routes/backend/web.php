<?php

use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Route;


//login route start
Route::get('/', [LoginController::class, 'login_show'])->name('login.show');
Route::post('/do-login', [LoginController::class, 'do_login'])->name('do.login');
//login route end


//forget password route start
Route::get('/forget-password', [ForgetPasswordController::class, 'getEmail'])->name('get.email');
Route::post('/forget-password', [ForgetPasswordController::class, 'postEmail'])->name('post.email');
Route::get('reset-password/{token}/{email}', [ForgetPasswordController::class, 'getPassword'])->name('get.password');
Route::post('reset-password/{email}', [ForgetPasswordController::class, 'reset_password'])->name('password.reset');
//forget password route end


//logout route start
Route::post('/do-logout', [LogoutController::class, 'do_logout'])->name('do.logout');
//logout route end

//backend route group start
Route::group(['prefix' => 'admindashboard', 'middleware' => 'auth'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //order progress
    Route::get('order-progress', [DashboardController::class, 'order_progress'])->name('order.progress');

    //profile module routes start
    Route::group(['prefix' => 'profile-module'], function () {
        require_once 'profile_module/profile.php';
    });
    //profile module routes end

    //user module routes start
    Route::group(['prefix' => 'user-module'], function(){
        require_once 'user_module/user.php';
        require_once 'user_module/role.php';
    });
    //user module routes end

    //location module routes start
    Route::group(['prefix' => 'location-module'], function(){
        require_once 'location_module/company.php';
        require_once 'location_module/location.php';
    });
    //location module routes end

    //log sheet module routes start
    Route::group(['prefix' => 'log-sheet'], function(){
        require_once 'log_sheet_module/temperature_log.php';
    });
    //log sheet module routes end

    //settings module routes start
    Route::group(['prefix' => 'settings-module'], function () {
        require_once 'settings_module/app_info.php';
    });
    //settings module routes end

    //system module routes start
    Route::group(['prefix' => 'system-module'], function(){
        require_once 'system_module/device.php';
    });
    //system module routes end
    

    //common
    require_once 'common.php';

});
//backend route group end


?>