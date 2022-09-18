<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreezersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freezers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("group_id");
            $table->unsignedBigInteger("company_id");
            $table->unsignedBigInteger("location_id");
            $table->string("name")->unique();

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
        Schema::dropIfExists('freezers');
    }
}
