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
            $table->integer('AreasQuestConnect');
            $table->integer('idUser');
            $table->foreign('AreasQuestConnect')->references('id')->on('areas_quest_connects');
            $table->foreign('idUser')->references('id')->on('users');
            $table->double('avgPotential');
            $table->double('avgPerformance');
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
