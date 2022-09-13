<?php

use App\Http\Controllers\Backend\CustomerModule\Message\MessageController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'message'], function(){

     //index
     Route::get("",[MessageController::class,"index"])->name("message.all");

     //view route
     Route::get("view/{id}",[MessageController::class,"view_modal"])->name("message.view.modal");

     //delete route
     Route::get("delete",[MessageController::class,"delete"])->name("message.delete");
     Route::get("delete-all",[MessageController::class,"delete_all"])->name("message.delete.all");

});

?>