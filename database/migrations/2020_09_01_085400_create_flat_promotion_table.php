<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlatPromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flat_promotion', function (Blueprint $table) {
            $table->unsignedBigInteger('flat_id');
            $table->unsignedBigInteger('promotion_id');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('end_at')->nullable();
            

            $table->foreign('flat_id')->references('id')->on('flats')->onDelete('cascade');
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');

            $table->primary(['flat_id', 'promotion_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flat_promotion');
    }
}
