<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quest_surveys', function (Blueprint $table) {
            $table->integer('idSurvey');
            $table->integer('idQuestion');
            $table->primary('idSurvey');
            $table->primary('idQuestion');
            $table->foreign('idSurvey')->references('id')->on('surveys');
            $table->foreign('idQuestion')->references('id')->on('questions');
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
        Schema::dropIfExists('quest_surveys');
    }
}
