<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('idusertype');
            $table->foreign('idusertype')->references('id')->on('user_types');
            $table->integer('iddepartment');
            $table->foreign('iddepartment')->references('id')->on('departments');
            $table->integer('idcontract');
            $table->foreign('idcontract')->references('id')->on('contracts');
            $table->string('address');
            $table->string('academicQual');
            $table->string('phone');
            $table->string('photo');
            $table->date('birthDate');
            $table->string('status');
            $table->integer('taxNumber');
            $table->integer('IBAN');
            $table->string('sosContact');
            $table->string('sosRelationship');
            $table->string('sosName');      
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
