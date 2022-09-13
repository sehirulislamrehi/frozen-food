<?php

use App\Http\Controllers\Backend\ServiceModule\Duration\DurationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'duration'],function() {

     //index route
     Route::get("/",[DurationController::class,"index"])->name('duration.all');

     //data route
     Route::get("/data",[DurationController::class,"data"])->name('duration.data');

     //add route
     Route::get("/add-modal",[DurationController::class,"add_modal"])->name('duration.add.modal');
     Route::post("/add",[DurationController::class,"add"])->name('duration.add');

     //edit route
     Route::get("/edit-modal/{id}",[DurationController::class,"edit_modal"])->name('duration.edit.modal');
     Route::post("/edit/{id}",[DurationController::class,"edit"])->name('duration.edit');

     //view route
     Route::get("/view-modal/{id}",[DurationController::class,"view_modal"])->name('duration.view.modal');

});

?>