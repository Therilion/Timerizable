<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeIntervalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('timerizable.time_intervals_database', 'time_intervals'), function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('time_block_id');
            $table->time('starts_at');
            $table->time('ends_at');

            $table->foreign('time_block_id')
                ->references('id')->on('time_blocks')
                ->onDelete('cascade');
        });
    }
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('timerizable.time_intervals_database', 'time_intervals'));
    }
}
