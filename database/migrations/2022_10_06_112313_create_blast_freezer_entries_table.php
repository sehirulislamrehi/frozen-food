<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlastFreezerEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blast_freezer_entries', function (Blueprint $table) {
            $table->id();

            $table->string("code")->unique()->comment("Auto generated code"); 

            $table->unsignedBigInteger("group_id");
            $table->unsignedBigInteger("company_id");
            $table->unsignedBigInteger("location_id");

            $table->unsignedBigInteger("device_id");
            $table->unsignedBigInteger("trolley_id");
            $table->unsignedBigInteger("product_details_id");
            $table->dateTime("lead_time")->comment("Trolley out time");
            $table->dateTime("trolley_outed")->nullable();
            $table->double("quantity")->comment("Quantity in Kg");
            $table->enum("status",["In","Out"]);

            $table->foreign("group_id")->references("id")->on("locations")->onDelete("cascade");
            $table->foreign("company_id")->references("id")->on("locations")->onDelete("cascade");
            $table->foreign("location_id")->references("id")->on("locations")->onDelete("cascade");
            
            $table->foreign("device_id")->references("id")->on("devices")->onDelete("cascade");
            $table->foreign("trolley_id")->references("id")->on("trolleys")->onDelete("cascade");
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
        Schema::dropIfExists('blast_freezer_entries');
    }
}
