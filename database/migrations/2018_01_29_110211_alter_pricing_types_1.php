<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPricingTypes1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pricings', function(Blueprint $table) {
           $table->enum('occupation', ['All','Student','Non-Student'])->nullable();
           $table->boolean("islocal")->default(true);
        });

        Schema::table("personal_datas", function(Blueprint $table) {
            $table->boolean("islocal")->nullable();
        });

        Schema::table("pricing_types", function(Blueprint $table) {
            $table->enum("pricefor",["Conference","Publication","Workshop"])->nullable();
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
