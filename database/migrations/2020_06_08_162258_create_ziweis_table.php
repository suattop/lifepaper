<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZiweisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ziweis', function (Blueprint $table) {
            $table->id();
            $table->string('stem');
            $table->string('branch');
            $table->string('palace');
            $table->unsignedBigInteger('begin_age')->nullable();
            $table->unsignedBigInteger('end_age')->nullable();
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
        Schema::dropIfExists('ziweis');
    }
}
