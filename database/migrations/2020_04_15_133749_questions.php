<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Questions extends Migration
{
       /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->double('weight')->nullable();
            $table->integer('idPP')->nullable();
            $table->integer('idSubcat');
            $table->integer('idAreaOpenQuest')->nullable();
            $table->integer('idTypeQuestion');
            $table->foreign('idPP')->references('id')->on('pps');
            $table->foreign('idAreaOpenQuest')->references('id')->on('areas');
            $table->foreign('idSubcat')->references('id')->on('sub_categories');
            $table->foreign('idTypeQuestion')->references('id')->on('type_questions');
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
        Schema::dropIfExists('questions');
    }
}
