<?php

use App\Http\Controllers\Backend\SettingsModule\CustomPage\CustomPageController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'custom-page'], function(){

     //index
     Route::get("",[CustomPageController::class,"index"])->name("custom_page.all");

     //data
     Route::get("data",[CustomPageController::class,"data"])->name("custom_page.data");

     //add
     Route::get("add-modal",[CustomPageController::class,"add_modal"])->name("custom_page.add.modal");
     Route::post("add",[CustomPageController::class,"add"])->name("custom_page.add");

     //edit
     Route::get("edit-modal/{id}",[CustomPageController::class,"edit_modal"])->name("custom_page.edit.modal");
     Route::post("edit/{id}",[CustomPageController::class,"edit"])->name("custom_page.edit");
     
     //delete
     Route::get("delete-modal/{id}",[CustomPageController::class,"delete_modal"])->name("custom_page.delete.modal");
     Route::post("delete/{id}",[CustomPageController::class,"delete"])->name("custom_page.delete");
});

?>