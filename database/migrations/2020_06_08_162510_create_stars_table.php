<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('four_change')->nullable();
            $table->unsignedBigInteger('ziwei_id');
            $table->foreign('ziwei_id')->references('id')->on('ziweis')->onDelete('cascade');
            $table->unsignedBigInteger('destiny_id');
            $table->foreign('destiny_id')->references('id')->on('destinies')->onDelete('cascade');
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
        Schema::dropIfExists('stars');
    }
}
