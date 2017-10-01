<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     * unique default nullable
     * @return void
     */
    public function up()
    {

        Schema::create('servers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip',30);
            $table->mediumInteger('status')->default(0);
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
        Schema::drop('servers');
    }
}