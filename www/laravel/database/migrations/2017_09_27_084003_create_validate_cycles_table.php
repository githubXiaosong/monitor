<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidateCyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * unique default nullable
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validate_cycles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('days');
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
        Schema::drop('validate_cycles');
    }
}
