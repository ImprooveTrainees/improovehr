<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvgAllFinalsTable extends Migration
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
            $table->double('avgPerformanceFinal');
            $table->double('avgPotentialFinal');
            $table->date('Date');
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
        Schema::dropIfExists('avg_all_finals');
    }
}
