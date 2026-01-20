<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvenTimeExecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('even_time_exec', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_time_id');
            $table->unsignedBigInteger('exec_id');
            $table->foreign('exec_id')
                ->references('id')->on('execs')
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
        Schema::dropIfExists('even_time_exec');
    }
}
