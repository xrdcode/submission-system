<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('number');
            $table->string('building');
            $table->string('address');
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');

        });

        Schema::create('room_submissions', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('submission_id');
            $table->unsignedInteger('room_id');
            $table->unsignedInteger('queue');
            $table->dateTime('datetimes');;

            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_submissions');
        Schema::dropIfExists('rooms');
    }
}
