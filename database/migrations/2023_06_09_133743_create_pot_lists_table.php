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
        Schema::create('pot_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id')->default('0'); //Who Called
            $table->integer('dealership_id'); //Dealearchip assigned too
            $table->integer('pot_campaign_id'); //Campaign assigned too
            $table->string('title');
            $table->string('first_name')->nullable();
            $table->string('last_name');
            $table->string('registration');
            $table->string('email');
            $table->string('phone')->nullable();
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
        Schema::dropIfExists('pot_lists');
    }
};
