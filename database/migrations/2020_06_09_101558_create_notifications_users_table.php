<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('notificationId');
            $table->foreign('notificationId')->references('id')->on('notifications');
            $table->integer('createUserId');
            $table->foreign('createUserId')->references('id')->on('users');
            $table->integer('receiveUserId');
            $table->foreign('receiveUserId')->references('id')->on('users');
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
        Schema::dropIfExists('notifications_users');
    }
}
