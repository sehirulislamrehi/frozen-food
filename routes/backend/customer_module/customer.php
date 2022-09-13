<?php

use App\Http\Controllers\Backend\CustomerModule\Customer\CustomerController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'customer'], function(){

     //index
     Route::get("",[CustomerController::class,"index"])->name("customer.all");

     //edit
     Route::get("edit/{id}",[CustomerController::class,"edit_modal"])->name("customer.edit.modal");
     Route::post("edit/{id}",[CustomerController::class,"edit"])->name("customer.edit");

     //view
     Route::get("view/{id}",[CustomerController::class,"view_modal"])->name("customer.view.modal");

});

?>