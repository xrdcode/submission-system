<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTicketInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshop_tickets', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('code');
            $table->boolean('used')->default(false);
            $table->dateTime('checked_in')->nullable();
            $table->unsignedInteger('general_payment_id');
            $table->timestamps();

            $table->foreign('general_payment_id')->references('id')
                ->on('general_payments')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshop_tickets');
    }
}
