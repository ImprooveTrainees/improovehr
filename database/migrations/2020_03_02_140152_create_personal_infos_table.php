<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_infos', function (Blueprint $table) {
            $table->integer('user_id');
            $table->primary('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('address');
            $table->string('academic_qual');
            $table->string('phone');
            $table->string('photo');
            $table->date('birth_date');
            $table->string('status');
            $table->integer('tax_number');
            $table->string('iban');
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
        Schema::dropIfExists('personal_infos');
    }
}
