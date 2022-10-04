<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("product_details_id");
            $table->double("quantity")->comment("Quantity in kg");
            $table->enum('type',['In','Out']);
            $table->dateTime("date_time");
            $table->string("cartoon_name")->nullable();
            
            $table->foreign("product_details_id")->references("id")->on("product_details")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_stocks');
    }
}
