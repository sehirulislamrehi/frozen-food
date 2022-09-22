<?php

use App\Http\Controllers\Backend\UserModule\User\UserCoverageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserModule\User\UserController;
use App\Http\Controllers\Backend\UserModule\User\UserDebitCreditController;

//user start 
    Route::group(['prefix' => 'user'], function(){
        
        Route::get("/",[UserController::class,'index'])->name('user.all');
        Route::get("/data",[UserController::class,'data'])->name('user.data');

        //user add
        Route::get("/add",[UserController::class,'add_modal'])->name('user.add.modal');
        Route::post("/add",[UserController::class,'add'])->name('user.add');

        //user edit
        Route::get("/edit/{id}",[UserController::class,'edit'])->name('user.edit');
        Route::post("/edit/{id}",[UserController::class,'update'])->name('user.update');

    }); 
    //user end


?>