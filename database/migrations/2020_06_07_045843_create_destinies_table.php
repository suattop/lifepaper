<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestiniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinies', function (Blueprint $table) {
            $table->id();
            $table->string('gender');
            $table->unsignedInteger('born_year');
            $table->unsignedInteger('born_month');
            $table->unsignedInteger('born_day');
            $table->unsignedInteger('born_hour');
            $table->string('year_stem');
            $table->string('year_branch');
            $table->string('month_stem');
            $table->string('month_branch');
            $table->string('day_stem');
            $table->string('day_branch');
            $table->string('hour_stem');
            $table->string('hour_branch');
            $table->unsignedInteger('lunar_year');
            $table->unsignedInteger('lunar_month');
            $table->unsignedInteger('lunar_day');
            $table->unsignedInteger('lunar_hour');
            $table->string('lunar_year_chi');
            $table->string('lunar_month_chi');
            $table->string('lunar_day_chi');
            $table->string('lunar_hour_chi');
            $table->string('animal');
            $table->string('week_name');
            $table->unsignedBigInteger('analysis_id')->nullable();
            $table->foreign('analysis_id')->references('id')->on('analyses')->onDelete('cascade');
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
        Schema::dropIfExists('destinies');
    }
}
