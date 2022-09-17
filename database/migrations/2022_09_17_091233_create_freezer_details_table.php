<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreezerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freezer_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("freezer_id");
            $table->unsignedBigInteger("device_id");
            $table->unsignedBigInteger("device_manual_id");

            $table->foreign("freezer_id")->references("id")->on("freezers")->onDelete("cascade");
            $table->foreign("device_id")->references("id")->on("devices")->onDelete("cascade");

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
        Schema::dropIfExists('freezer_details');
    }
}
