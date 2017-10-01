<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoliciesTable extends Migration
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
        Schema::create('policies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('timestamp');
            $table->unsignedInteger('interval_id');
            $table->unsignedInteger('stream_id');//应该先创建流再创建策略 要不然没有这个ID 所以至少两次SQL Insert
            $table->timestamps();

            $table->foreign('interval_id')->references('id')->on('intervals');
            $table->foreign('stream_id')->references('id')->on('streams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('policies');
    }
}
