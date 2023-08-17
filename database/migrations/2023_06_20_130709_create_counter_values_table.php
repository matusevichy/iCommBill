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
        Schema::create('counter_values', function (Blueprint $table) {
            $table->id();
            $table->double('value');
            $table->date('date');
            $table->bigInteger('counter_id')->unsigned();
            $table->timestamps();
            $table->foreign('counter_id')->references('id')->on('counters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counter_values');
    }
};
