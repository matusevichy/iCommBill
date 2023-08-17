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
        Schema::create('abonents', function (Blueprint $table) {
            $table->id();
            $table->string('account_number');
            $table->string('location_number');
            $table->string('street')->nullable();
            $table->double('square');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('organization_id')->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('organization_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abonents');
    }
};
