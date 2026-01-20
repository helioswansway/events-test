<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pot_lists', function (Blueprint $table) {
            //
            $table->string('call_attempts')->nullable(); //Number Of call attempts
            $table->string('call_status')->nullable();
            $table->integer('message_left')->default('0'); //Number Of call attempts
            $table->string('booking_status')->nullable();
            $table->string('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pot_lists', function (Blueprint $table) {
            //
        });
    }
};
