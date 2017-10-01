<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartTimeAndEndTimeToStreams extends Migration
{
    /**
     * Run the migrations.
     * unique default nullable
     * @return void
     */
    public function up()
    {
        Schema::table('streams', function (Blueprint $table) {
            $table->unsignedInteger('start_timestamp');
            $table->unsignedInteger('end_timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('streams', function (Blueprint $table) {
            $table->drop('start_timestamp');
            $table->drop('end_timestamp');
        });
    }
}
