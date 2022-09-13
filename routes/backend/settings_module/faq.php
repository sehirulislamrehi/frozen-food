<?php

use App\Http\Controllers\Backend\SettingsModule\Faq\FaqController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'faq'], function(){

     //index
     Route::get("",[FaqController::class,"index"])->name("faq.all");

     //data
     Route::get("data",[FaqController::class,"data"])->name("faq.data");

     //add route
     Route::get("add-modal",[FaqController::class,"add_modal"])->name("faq.add.modal");
     Route::post("add",[FaqController::class,"add"])->name("faq.add");

     //edit route
     Route::get("edit-modal/{id}",[FaqController::class,"edit_modal"])->name("faq.edit.modal");
     Route::post("edit/{id}",[FaqController::class,"edit"])->name("faq.edit");

     //delete route
     Route::get("delete-modal/{id}",[FaqController::class,"delete_modal"])->name("faq.delete.modal");
     Route::post("delete/{id}",[FaqController::class,"delete"])->name("faq.delete");
});

?>