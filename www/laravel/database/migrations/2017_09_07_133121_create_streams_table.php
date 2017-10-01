<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * unqiue default nullable
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->unsignedInteger('collect_current_interval_id')->default(1);
            $table->unsignedInteger('image_num_expected_val');//预期可用图片
            $table->unsignedInteger('image_num_current_val')->nullable();//可用的图片
            $table->unsignedInteger('image_num_current')->nullable();//采集到的图片
            $table->unsignedInteger('acc_expected');
            $table->unsignedInteger('acc_current')->nullable();
            $table->unsignedSmallInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('collect_current_interval_id')->references('id')->on('intervals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('streams');
    }
}
