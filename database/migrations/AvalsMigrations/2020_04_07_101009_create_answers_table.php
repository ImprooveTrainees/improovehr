<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('idAnswer');
            $table->integer('idQuestSurvey');
            $table->integer('idUserEvaluated')->nullable();
            $table->integer('idUserEvaluator')->nullable();
            $table->string('value');
            $table->foreign('idUserEvaluated')->references('id')->on('users');
            $table->foreign('idUserEvaluator')->references('id')->on('users');
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
        Schema::dropIfExists('answers');
    }
}
