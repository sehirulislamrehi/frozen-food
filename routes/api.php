<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//==================== Auth Routes ====================//
Route::group(['prefix' => 'auth'], function () {

	Route::post('register', [AuthController::class, 'register']);
	Route::post('resend-code', [AuthController::class, 'resend_code']);
	Route::post('verify', [AuthController::class, 'verify']);
	Route::post('login', [AuthController::class, 'login']);
	Route::post('logout', [AuthController::class, 'logout']);
	Route::post('refresh', [AuthController::class, 'refresh']);
	Route::post('profile', [AuthController::class, 'profile']);
	Route::post('update-profile', [AuthController::class, 'update_profile']);

	//forget password
	Route::post("reset-password",[AuthController::class,"reset_password"]);

});

//==================== session manage ====================//
Route::get("manage-session/{token}",[AuthController::class,"manage_session"]);

//delete user image
Route::post('delete-image', [AuthController::class, 'delete_image']);

//change password
Route::post('change-password', [AuthController::class, 'change_password']);


//get all service
Route::get("get-all-services/",[ServiceController::class,"get_all_service"]);
Route::get("service-details/{slug}",[ServiceController::class,"service_details"]);

//postal code wise area
Route::post("postal-code-area",[LocationController::class,"postal_code_area"]);

//get date and time for order place
Route::get("date-and-time",[OrderController::class,"date_and_time"]);

//place order
Route::post("place-order",[OrderController::class,"place_order"]);

//get order
Route::get("get-order/{token}",[OrderController::class,"get_order"]);

//order details
Route::post("order-details/{order_no}",[OrderController::class,"order_details"]);

//order dashboard data
Route::get("order-data/{token}",[OrderController::class,"order_data"]);

//banner data
Route::get("banner-data",[ApiController::class,"banner_data"]);

//faq data
Route::get("faq-data",[ApiController::class,"faq_data"]);

//custom page
Route::get("custom-page",[ApiController::class,"custom_page"]);
Route::get("custom-page-details/{slug}",[ApiController::class,"custom_page_details"]);

//application information
Route::get("application-data",[ApiController::class,"application_data"]);

//submit contact form
Route::post("contact-form",[ApiController::class,"contact_form"]);

//do subscribe
Route::post("do-subscribe",[ApiController::class,"do_subscribe"]);

//get testimonials
Route::get("get-testimonials/{value}",[ApiController::class,"get_testimonials"]);