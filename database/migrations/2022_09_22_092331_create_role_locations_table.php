<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_locations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("role_id");
            $table->unsignedBigInteger("location_id");
            $table->enum("type",["Group","Company","Location"]);

            $table->foreign("role_id")->references("id")->on("roles")->onDelete("cascade");
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
        Schema::dropIfExists('role_locations');
    }
}
