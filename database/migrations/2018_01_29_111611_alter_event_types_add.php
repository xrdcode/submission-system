<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEventTypesAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('submission_events', function(Blueprint $table) {
           $table->enum('eventfor', ["Participant", "Non-Participant"]);
        });

        Schema::table('submissions', function(Blueprint $table) {
           $table->boolean('ispublicationonly')->nullable();
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
