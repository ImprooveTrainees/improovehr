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
            $table->integer('idUser')->nullable();
            $table->integer('idSurvey');
            $table->foreign('idUser')->references('id')->on('users');
            $table->foreign('idSurvey')->references('id')->on('surveys');
            $table->double('avgPotentialFinal');
            $table->double('avgPerformanceFinal');
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
