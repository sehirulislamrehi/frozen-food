<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartoonDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartoon_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cartoon_id');
            $table->unsignedBigInteger('blast_freezer_entries_id');
            $table->unsignedBigInteger("product_details_id");
            $table->double("quantity")->comment("quantity in kg.");

            $table->foreign("cartoon_id")->references("id")->on("cartoons")->onDelete("cascade");
            $table->foreign("blast_freezer_entries_id")->references("id")->on("blast_freezer_entries")->onDelete("cascade");
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
        Schema::dropIfExists('cartoon_details');
    }
}
