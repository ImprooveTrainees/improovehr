<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyCompletesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_completes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idUserEvaluated');
            $table->integer('idUserEvaluator');
            $table->foreign('idUserEvaluated')->references('id')->on('users');
            $table->foreign('idUserEvaluator')->references('id')->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_completes');
    }
}
