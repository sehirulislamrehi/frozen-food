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
            $table->double('actual_cartoon_weight')->comment("weight in kg. Manual entry");
            $table->double('cartoon_weight')->comment("weight in kg. Auto calculated.");
            $table->integer('packet_quantity');
            $table->double('per_packet_weight')->comment("weight in kg");
            $table->integer('per_packet_item')->nullable();
            $table->integer('sample_item')->default(0);
            $table->enum('status',['In','Out']);
            $table->unsignedBigInteger("product_id");
            $table->date("manufacture_date");
            $table->date("expiry_date");

            $table->unsignedBigInteger("group_id");
            $table->unsignedBigInteger("company_id");
            $table->unsignedBigInteger("location_id");

            $table->foreign("group_id")->references("id")->on("locations")->onDelete("cascade");
            $table->foreign("company_id")->references("id")->on("locations")->onDelete("cascade");
            $table->foreign("location_id")->references("id")->on("locations")->onDelete("cascade");
            
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
