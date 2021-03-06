<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AvgSurveyFinal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avgSurveyFinal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idUser');
            $table->integer('idSurvey');
            $table->double('avgPotentialFinal');
            $table->double('avgPerformanceFinal');
            $table->date('date');
            $table->foreign('idUser')->references('id')->on('users');
            $table->foreign('idSurvey')->references('id')->on('surveys');
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
        Schema::dropIfExists('avgSurveyFinal');
    }
}
