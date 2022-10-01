<?php

use App\Http\Controllers\Backend\SystemModule\Products\ProductDetailsController;
use App\Http\Controllers\Backend\SystemModule\Products\ProductsController;
use App\Http\Controllers\Backend\SystemModule\Products\ProductStockController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'products'], function(){

    //index 
    Route::get("",[ProductsController::class,"index"])->name("products.all");

    //add
    Route::get("add-page",[ProductsController::class,"add_page"])->name("products.add.page");
    Route::post("add",[ProductsController::class,"add"])->name("products.add");

    //edit
    Route::get("edit-page/{code}",[ProductsController::class,"edit_page"])->name("products.edit.page");
    Route::post("edit/{id}",[ProductsController::class,"edit"])->name("products.edit");


    //product details route group
    Route::group(['prefix' => 'details'], function(){
        
        //data route
        Route::get("data/{code}",[ProductDetailsController::class,"data"])->name("products.details.data");

        //add
        Route::get("add-modal/{id}",[ProductDetailsController::class,"add_modal"])->name("products.details.add.modal");
        Route::post("add/{id}",[ProductDetailsController::class,"add"])->name("products.details.add");

        //edit
        Route::get("edit-modal/{id}",[ProductDetailsController::class,"edit_modal"])->name("products.details.edit.modal");
        Route::post("edit/{id}",[ProductDetailsController::class,"edit"])->name("products.details.edit");

        //stock add
        Route::get("stock-add-modal/{id}",[ProductStockController::class,"stock_add_modal"])->name("products.details.stock.add.modal");
        Route::post("stock-add/{id}",[ProductStockController::class,"stock_add"])->name("products.details.stock.add");

        //stock summary
        Route::get("stock-summary/{id}",[ProductStockController::class,"stock_summary"])->name("products.details.stock.summary");

    });
    //product details route group

    

});

?>