<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvgSurveyFinalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avg_survey_finals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idSurveyComplete');
            $table->double('avgPotentialFinal');
            $table->double('avgPerformanceFinal');
            $table->foreign('idSurveyComplete')->references('id')->on('survey_completes');
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
        Schema::dropIfExists('avg_survey_finals');
    }
}
