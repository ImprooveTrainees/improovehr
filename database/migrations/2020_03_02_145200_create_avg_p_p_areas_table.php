<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvgPPAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avg_p_p_areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idSurveyComplete');
            $table->integer('Area');
            $table->double('avgPotential');
            $table->double('avgPerformance');
            $table->foreign('idSurveyComplete')->references('id')->on('survey_completes');
            $table->foreign('idArea')->references('id')->on('areas');
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
        Schema::dropIfExists('avg_p_p_areas');
    }
}
