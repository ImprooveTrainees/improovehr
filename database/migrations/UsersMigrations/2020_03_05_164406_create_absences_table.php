<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('iduser');

            $table->foreign('iduser')->references('id')->on('users');

            $table->integer('absencetype');

            $table->foreign('absencetype')->references('id')->on('absences');

            $table->string('attachment');

            $table->string('status');

            $table->datetime('start_date');

            $table->datetime('end_date');

            $table->string('motive');


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
        Schema::dropIfExists('absences');
    }
}
