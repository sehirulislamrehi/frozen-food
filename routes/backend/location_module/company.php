<?php

use App\Http\Controllers\Backend\LocationModule\Company\CompanyController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'company'], function(){

    //index
    Route::get("",[CompanyController::class,"index"])->name("company.all");

    //data
    Route::get("data",[CompanyController::class,"data"])->name("company.data");

    //add 
    Route::get("add-modal",[CompanyController::class,"add_modal"])->name("company.add.modal");
    Route::post("add",[CompanyController::class,"add"])->name("company.add");

    //edit 
    Route::get("edit-modal/{id}",[CompanyController::class,"edit_modal"])->name("company.edit.modal");
    Route::post("edit/{id}",[CompanyController::class,"edit"])->name("company.update");

});

?>