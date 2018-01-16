<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('address');
            $table->boolean('active')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('identity_types', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();

            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
        });

//        Schema::create('biodatas', function(Blueprint $table) {
//            $table->increments('id');
//            $table->unsignedInteger('user_id')->unique();
//            $table->string('nik');
//            $table->string('identity_number')->nullable();
//            $table->unsignedInteger('identity_type_id')->nullable();
//            $table->timestamps();
//
//            $table->foreign('user_id')
//                ->references('id')->on('users')
//                ->onDelete('cascade');
//
//            $table->foreign('identity_type_id')
//                ->references('id')->on('identity_types')
//                ->onDelete('set null');
//
//        });


    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('biodatas');
        Schema::dropIfExists('identity_types');
    }
}
