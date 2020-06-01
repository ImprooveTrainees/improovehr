<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('iduser');
            $table->foreign('iduser')->references('id')->on('users');
            $table->string('name');
            $table->foreign('name')->references('name')->on('users');
            $table->string('status');
            $table->foreign('status')->references('status')->on('absences');
            $table->string('description');
            $table->foreign('description')->references('description')->on('absence_types');
            $table->datetime('start_date');
            $table->datetime('end_date');
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
        Schema::dropIfExists('reports');
    }
}
