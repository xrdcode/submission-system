<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('address');
            $table->boolean('active')->default(false);
            $table->rememberToken();
            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');

        });

        Schema::create('roles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
        });

        Schema::create('groups', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');

            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
        });

        Schema::create('admin_group', function(Blueprint $table) {
            $table->unsignedInteger('admin_id');
            $table->unsignedInteger('group_id');

            $table->unique(['admin_id','group_id']);

            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');

        });
        Schema::create('group_role', function(Blueprint $table) {
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('role_id');

            $table->unique(['group_id','role_id']);

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::create('activity_logs', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->nullable();
            $table->string('action');
            $table->string('detail');
            $table->text('old_value');
            $table->text('new_value');

            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
        });

        Schema::create('system_settings', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('value')->nullable();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
            $table->timestamps();

        });

        Schema::create('message_types', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('classname');
            $table->unsignedInteger('message_type_id');
            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('flash_message', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('text');
            $table->unsignedInteger('message_type_id');

            $table->foreign('message_type_id')->references('id')->on('message_types')->onDelete('cascade');

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();


            $table->timestamps();

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
        //
    }
}
