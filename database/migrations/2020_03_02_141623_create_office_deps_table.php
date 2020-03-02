<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeDepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_deps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('iddepartments');
            $table->integer('idoffice');

            $table->foreign('iddepartments')->references('id')->on('departments');
            $table->foreign('idoffice')->references('id')->on('offices');
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
        Schema::dropIfExists('office_deps');
    }
}
