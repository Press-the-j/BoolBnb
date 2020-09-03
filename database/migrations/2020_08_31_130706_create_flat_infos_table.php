<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlatInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flat_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flat_id');
            $table->string('image_path')->nullable();//se non dovesse essere caricata caricheremo una img default
            $table->text('description');
            $table->string('city');
            $table->string('address');
            $table->string('postal_code');
            $table->integer('square_meters')->unsigned();
            $table->float('price', 6 ,2);
            $table->unsignedTinyInteger('max_guest');
            $table->unsignedTinyInteger('rooms');
            $table->unsignedTinyInteger('baths');
            $table->timestamps();
            $table->foreign('flat_id')->references('id')->on('flats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flat_infos');
    }
}
