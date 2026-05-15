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
        Schema::table('archive_appointments', function (Blueprint $table) {
            //
            $table->string('file_path');
            $table->string('event_dates');
            $table->string('event_name');
            $table->string('count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('archive_appointments', function (Blueprint $table) {
            //
            $table->dropColumn(['appointment', 'event']);
        });
    }
};
