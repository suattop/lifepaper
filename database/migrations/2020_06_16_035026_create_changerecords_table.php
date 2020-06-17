<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangerecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('changerecords', function (Blueprint $table) {
            $table->id();
            $table->string('self_palace')->nullable();
            $table->string('change_palace')->nullable();
            $table->string('four_change')->nullable();
            $table->string('star_name')->nullable();
            $table->unsignedBigInteger('destiny_id')->nullable();
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
        Schema::dropIfExists('changerecords');
    }
}
