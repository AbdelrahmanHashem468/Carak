<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolarPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solar_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('oli82price');
            $table->string('oli92price');
            $table->string('oli95price');
            $table->string('solarprice');
            $table->string('gasprice');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solar__prices');
    }
}
