<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficesDepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices_deps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idDepartment');
            $table->foreign('idDepartment')->references('id')->on('departments');
            $table->integer('idOffice');
            $table->foreign('idOffice')->references('id')->on('offices');
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
        Schema::dropIfExists('offices_deps');
    }
}
