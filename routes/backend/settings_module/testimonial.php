<?php

use App\Http\Controllers\Backend\SettingsModule\Testimonial\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'testimonial'], function(){

     //index
     Route::get("",[TestimonialController::class,"index"])->name("testimonial.all");

     //data
     Route::get("data",[TestimonialController::class,"data"])->name("testimonial.data");

     //add
     Route::get("add-modal",[TestimonialController::class,"add_modal"])->name("testimonial.add.modal");
     Route::post("add",[TestimonialController::class,"add"])->name("testimonial.add");

     //edit
     Route::get("edit-modal/{id}",[TestimonialController::class,"edit_modal"])->name("testimonial.edit.modal");
     Route::post("edit/{id}",[TestimonialController::class,"edit"])->name("testimonial.edit");
     
     //delete
     Route::get("delete-modal/{id}",[TestimonialController::class,"delete_modal"])->name("testimonial.delete.modal");
     Route::post("delete/{id}",[TestimonialController::class,"delete"])->name("testimonial.delete");


});

?>