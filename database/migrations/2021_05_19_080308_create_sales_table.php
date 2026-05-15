<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->integer('book_id');
            $table->integer('exec_id');
            $table->integer('dealership_id');
            $table->integer('vehicle')->nullable();
            $table->integer('finance')->nullable();
            $table->integer('paint_protection')->nullable();
            $table->integer('warranty')->nullable();
            $table->integer('gap')->nullable();
            $table->integer('smart')->nullable();
            $table->string('order_number');
            $table->string('from_appointment');
            $table->string('sale_type');
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
        Schema::dropIfExists('sales');
    }
}
