<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_tasks', function(Blueprint $table) {
           $table->increments('id');
           $table->string('name');
           $table->string('notes')->nullable();
           $table->unsignedInteger('submission_id')->nullable();
           $table->unsignedInteger('submission_event_id')->nullable();
           $table->unsignedInteger('user_id')->nullable();

           $table->timestamps();

           $table->foreign('submission_id')->references('id')->on('submissions')->onDelete('set null');
           $table->foreign('submission_event_id')->references('id')->on('submission_events')->onDelete('set null');


            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('user_id')->references('id')->on('admins')->onDelete('set null');
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
        Schema::dropIfExists('admin_task');
    }
}
