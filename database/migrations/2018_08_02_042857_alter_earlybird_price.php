<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEarlybirdPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("pricings", function (Blueprint $table) {
            $table->bigInteger("early_price")->nullable();
            $table->dateTime(("early_date_until"))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("pricings", function (Blueprint $table) {
            $table->removeColumn("early_price");
            $table->removeColumn(("early_date_until"));
        });
    }
}
