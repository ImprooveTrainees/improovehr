<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AvgAllFinals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avg_all_finals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idUser');
            $table->integer('idSurvey');
            $table->double('avgPerformanceFinal');
            $table->double('avgPotentialFinal');
            $table->date('Date');
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
        Schema::dropIfExists('avg_all_finals');
    }
}
