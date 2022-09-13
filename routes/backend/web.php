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

    //area in zipcode
    Route::get('zipcode-area', [DashboardController::class, 'zipcode_area'])->name('zipcode.area');

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
    Route::group(['prefix' => 'location-module'], function () {
        require_once 'location_module/zipcode.php';
        require_once 'location_module/emirate.php';
        require_once 'location_module/area.php';
        require_once 'location_module/zone.php';
    });
    //location module routes end

    //service module routes start
    Route::group(['prefix' => 'service-module'], function () {
        require_once 'service_module/duration.php';
        require_once 'service_module/coupon.php';
        require_once 'service_module/service.php';
    });
    //service module routes end

    //order module routes start
    Route::group(['prefix' => 'order-module'], function () {
        require_once 'order_module/all_order.php';
    });
    //order module routes end

    //customer module routes start
    Route::group(['prefix' => 'customer-module'], function () {
        require_once 'customer_module/customer.php';
        require_once 'customer_module/message.php';
        require_once 'customer_module/subscribers.php';
    });
    //customer module routes end

    //settings module routes start
    Route::group(['prefix' => 'settings-module'], function () {
        require_once 'settings_module/app_info.php';
        require_once 'settings_module/banner.php';
        require_once 'settings_module/faq.php';
        require_once 'settings_module/custom_page.php';
        require_once 'settings_module/testimonial.php';
    });
    //settings module routes end

    
});
//backend route group end


?>