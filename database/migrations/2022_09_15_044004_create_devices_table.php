<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            
            $table->integer("device_number")->unique();
            $table->integer("device_manual_id")->unique();
            $table->unsignedBigInteger("group_id");
            $table->unsignedBigInteger("company_id");
            $table->unsignedBigInteger("location_id");
            $table->enum('type',["Blast Freeze", "Pre Cooler"]);

            $table->foreign("group_id")->references("id")->on("locations")->onDelete("cascade");
            $table->foreign("company_id")->references("id")->on("locations")->onDelete("cascade");
            $table->foreign("location_id")->references("id")->on("locations")->onDelete("cascade");

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
        Schema::dropIfExists('devices');
    }
}
