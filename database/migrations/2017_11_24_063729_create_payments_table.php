<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricing_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');

            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');

        });

        Schema::create('pricings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->unsignedInteger('submission_event_id');
            $table->unsignedInteger('pricing_type_id');
            $table->unsignedInteger('price');

            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('pricing_type_id')->references('id')->on('pricing_types')->onDelete('cascade');

        });

        Schema::create('payment_submissions', function (Blueprint $table) {
            $table->increments('id');

            $table->text('file')->nullable();
            $table->boolean('verified')->default(false);
            $table->unsignedInteger('submission_id');
            $table->unsignedInteger('pricing_id');

            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');

            $table->foreign('submission_id')->references('id')->on('submissions')->onDelete('cascade');
            $table->foreign('pricing_id')->references('id')->on('pricings')->onDelete('cascade');
        });

        Schema::create('general_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('submission_event_id')->nullable();
            $table->unsignedInteger('pricing_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('workstate_id');
            $table->text('file')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('verified')->default(false);

            $table->timestamps();

            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('submission_event_id')->references('id')->on('submission_events')->onDelete('set null');
            $table->foreign('pricing_id')->references('id')->on('pricings')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('workstate_id')->references('id')->on('workstates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_payments');
        Schema::dropIfExists('payment_submission');
        Schema::dropIfExists('pricings');
        Schema::dropIfExists('pricing_type');
    }
}
