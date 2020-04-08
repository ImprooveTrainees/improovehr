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
            $table->integer('idUserEvaluated')->nullable();
            $table->integer('idUserEvaluator')->nullable();
            $table->foreign('AreasQuestConnect')->references('id')->on('areas_quest_connects');
            $table->foreign('idUserEvaluated')->references('id')->on('users');
            $table->foreign('idUserEvaluator')->references('id')->on('users');
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
