<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AvgAllSurveysUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avgAllSurveysUser', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idUser');
            $table->double('avgPotentialFinal');
            $table->double('avgPerformanceFinal');
            $table->date('date');
            $table->foreign('idUser')->references('id')->on('users');
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
        Schema::dropIfExists('avgAllSurveysUser');
    }
}
