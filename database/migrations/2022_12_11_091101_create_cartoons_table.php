<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartoonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartoons', function (Blueprint $table) {
            $table->id();

            $table->string('cartoon_name');
            $table->string('cartoon_code');
            $table->double('cartoon_weight')->comment("weight in kg");
            $table->integer('packet_quantity');
            $table->double('per_packet_weight')->comment("weight in kg");
            $table->integer('per_packet_item');
            $table->enum('status',['In','Out']);
            $table->unsignedBigInteger("product_id");

            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade");

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
        Schema::dropIfExists('cartoons');
    }
}
