<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersFlextime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_flextime', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('idUser');
            $table->string('harvestApi_token');
            $table->integer('acc_id');
            $table->string('harvest_mail')->nullable();
            $table->double('hoursDoneWeek')->nullable();
            $table->double('hoursToDoWeek')->nullable();
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
        Schema::dropIfExists('users_flextime');
    }
}
