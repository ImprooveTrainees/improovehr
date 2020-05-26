<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SettingsGeneral extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_general', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('flextime_startDay'); //dias semana 1 a 7
            $table->integer('flextime_endDay'); //dias semana 1 a 7
            $table->integer('flextime_weeklyHours');
            $table->integer('limit_vacations')->nullable();
            $table->boolean('alert_holidays');
            $table->boolean('alert_birthdays');
            $table->boolean('alert_evaluations');
            $table->boolean('alert_flextime');
            $table->boolean('alert_notworking');
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
        Schema::dropIfExists('settings_general');
    }
}
