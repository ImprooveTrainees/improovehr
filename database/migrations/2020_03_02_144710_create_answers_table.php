<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('idAnswer');
            $table->integer('idSurveyComplete');
            $table->integer('idQuestion');
            $table->string('answer');
            $table->integer('value');
            $table->foreign('idSurveyComplete')->references('id')->on('survey_completes');
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
        Schema::dropIfExists('answers');
    }
}
