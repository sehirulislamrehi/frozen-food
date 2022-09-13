<?php

use App\Http\Controllers\Backend\CustomerModule\Subscriber\SubscriberController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'subscribers'], function(){

     //index
     Route::get("",[SubscriberController::class,"index"])->name("subscribers.all");

     //delete route
     Route::get("delete",[SubscriberController::class,"delete"])->name("subscribers.delete");
     Route::get("delete-all",[SubscriberController::class,"delete_all"])->name("subscribers.delete.all");

});

?>