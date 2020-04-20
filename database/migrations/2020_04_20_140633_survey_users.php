<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SurveyUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idUser');
            $table->integer('idSurvey');
            $table->boolean('submitted');
            $table->boolean('evaluated');
            $table->integer('evaluator');
            $table->date('dateLimit');
            $table->foreign('evaluator')->references('id')->on('users');
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
        Schema::dropIfExists('survey_users');
    }
}
