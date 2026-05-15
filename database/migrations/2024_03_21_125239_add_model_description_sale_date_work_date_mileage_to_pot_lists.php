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
            $table->string('model')->nullable()->after('customer_type');
            $table->string('description')->nullable()->after('model');
            $table->string('sale_date')->nullable()->after('description');
            $table->string('last_work_date')->nullable()->after('sale_date');
            $table->string('mileage')->nullable()->after('last_work_date');
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
