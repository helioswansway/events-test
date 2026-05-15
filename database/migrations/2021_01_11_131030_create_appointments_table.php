<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->integer('book_id');
            $table->integer('dealership_id');
            $table->string('date', 191)->nullable();
            $table->integer('event_time_id')->nullable();
            $table->integer('exec_id')->nullable();
            $table->string('model_interest', 191)->nullable();
            $table->string('vehicles', 2000)->nullable();
            $table->integer('part_exchange')->nullable();
            $table->string('mileage', 191)->nullable();
            $table->string('registration', 191)->nullable();
            $table->string('make', 191)->nullable();
            $table->string('colour', 191)->nullable();
            $table->string('fuel_type', 191)->nullable();
            $table->integer('friend_interest')->nullable();
            $table->integer('friend_model_interest')->nullable();
            $table->string('friend_name', 191)->nullable();
            $table->integer('confirm');
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
        Schema::dropIfExists('appointments');
    }
}
