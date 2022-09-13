<?php

use App\Http\Controllers\Backend\ServiceModule\Coupon\CouponController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'coupon'],function(){

     //index route
     Route::get("/",[CouponController::class,"index"])->name("coupon.all");

     //data route
     Route::get("/data",[CouponController::class,"data"])->name('coupon.data');

     //add route
     Route::get("/add-modal",[CouponController::class,"add_modal"])->name('coupon.add.modal');
     Route::post("/add",[CouponController::class,"add"])->name('coupon.add');

     //edit route
     Route::get("/edit-modal/{id}",[CouponController::class,"edit_modal"])->name('coupon.edit.modal');
     Route::post("/edit/{id}",[CouponController::class,"edit"])->name('coupon.edit');

     //view route
     Route::get("/view-modal/{id}",[CouponController::class,"view_modal"])->name('coupon.view.modal');

});

?>