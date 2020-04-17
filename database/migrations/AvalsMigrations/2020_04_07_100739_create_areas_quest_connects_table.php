<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasQuestConnectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas_quest_connects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idArea');
            $table->integer('idSurvey');
            $table->foreign('idArea')->references('id')->on('areas');
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
        Schema::dropIfExists('areas_quest_connects');
    }
}
