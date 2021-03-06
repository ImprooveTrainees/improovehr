<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();;
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->integer('idusertype')->nullable();
            $table->foreign('idusertype')->references('id')->on('user_types');
            $table->integer('iddepartment')->nullable();
            $table->foreign('iddepartment')->references('id')->on('departments');
            $table->integer('idcontract')->nullable();
            $table->foreign('idcontract')->references('id')->on('contracts');
            $table->string('address')->nullable();
            $table->string('academicQual')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->date('birthDate')->nullable();
            $table->string('status')->nullable();
            $table->integer('taxNumber')->nullable();
            $table->integer('IBAN')->nullable();
            $table->string('sosContact')->nullable();
            $table->string('sosRelationship')->nullable();
            $table->string('sosName')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('linkedIn')->nullable();
            $table->string('country')->nullable();
            $table->string('officeAdress')->nullable();
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
        Schema::dropIfExists('record_users');


    }
}
