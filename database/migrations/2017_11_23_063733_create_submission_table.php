<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submission_events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();

            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_thru')->nullable();

            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');

            $table->foreign('parent_id')
                ->references('id')
                ->on('submission_events')
                ->onDelete('set null');
        });

        Schema::create('workstate', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');

            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
        });

        Schema::create('file_papers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->string('path');
            $table->string('full_path');

            $table->timestamps();
        });

        Schema::create('submission_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');

            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
        });

        Schema::create('submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('abstract');
            $table->boolean('approved')->default(false);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('file_paper_id')->nullable();
            $table->unsignedInteger('submission_event_id')->nullable();
            $table->unsignedInteger('submission_status_id')->nullable();
            $table->unsignedInteger('workstate_id')->nullable();

            $table->timestamps();

            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('file_paper_id')->references('id')->on('file_papers')->onDelete('set null');
            $table->foreign('submission_event_id')->references('id')->on('submission_events')->onDelete('set null');
            $table->foreign('submission_status_id')->references('id')->on('submission_statuses')->onDelete('set null');
            $table->foreign('workstate_id')->references('id')->on('workstates')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');

        });

       Schema::create('event_schedules', function(Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('submission_event_id')->nullable();
          $table->string('submission_event_name')->nullable();
          $table->string('description', 200);
          $table->text('detail', 500);
          $table->text('location', 500);
          $table->text('notes', 500);
          $table->dateTime('valid_from');
          $table->dateTime('valid_thru');

          $table->timestamps();

           $table->unsignedInteger("created_by")->nullable();
           $table->unsignedInteger("updated_by")->nullable();

           $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
           $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
           $table->foreign('submission_event_id')->references('id')->on('submission_event_id')->onDelete('set null');
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
