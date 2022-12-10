<?php

use App\Http\Controllers\Backend\SettingsModule\EmailList\EmailListController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'email-list'], function(){

    //index
    Route::get("/",[EmailListController::class,"index"])->name("email.list.all");

    //data
    Route::get("data",[EmailListController::class,"data"])->name("email.list.data");

    //add-modal
    Route::get("add-modal",[EmailListController::class,"add_modal"])->name("email.list.add.modal");

});

?>