<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Answers extends Migration
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
            $table->integer('idQuestSurvey');
            $table->foreign('idQuestSurvey')->references('id')->on('quest_surveys');
            $table->integer('idUser');
            $table->foreign('idUser')->references('id')->on('users');
            $table->boolean('evaluated');
            $table->integer('willEvalue')->nullable();
            $table->foreign('willEvalue')->references('id')->on('users');
            $table->string('value');
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
