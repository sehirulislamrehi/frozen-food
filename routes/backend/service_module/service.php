<?php

use App\Http\Controllers\Backend\ServiceModule\Service\ServiceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'service'],function() {

     //index route
     Route::get("/",[ServiceController::class,"index"])->name('service.all');

     //sub services
     Route::get("sub-services/{id}",[ServiceController::class,"sub_services"])->name('sub.service.all');

     //data route
     Route::get("/data",[ServiceController::class,"data"])->name('service.data');

     //sub service data route
     Route::get("sub-service-data/{id}",[ServiceController::class,"sub_service_data"])->name('sub.service.data');

     //add route
     Route::get("/add-modal",[ServiceController::class,"add_modal"])->name('service.add.modal');
     Route::post("/add",[ServiceController::class,"add"])->name('service.add');

     //edit route
     Route::get("/edit-modal/{id}",[ServiceController::class,"edit_modal"])->name('service.edit.modal');
     Route::post("/edit/{id}",[ServiceController::class,"update"])->name('service.update');

     Route::get("/set-duration/{id}",[ServiceController::class,"set_duration"])->name('service.set.duration');
     Route::post("/set-duration/{id}",[ServiceController::class,"store_duration"])->name('service.store.duration');

     //view route
     Route::get("/view-modal/{id}",[ServiceController::class,"view_modal"])->name('service.view.modal');

});

?>