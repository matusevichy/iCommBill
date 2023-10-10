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
        Schema::table('tarifs', function (Blueprint $table) {
            $table->bigInteger('counterzonetype_id')->unsigned()->nullable();
            $table->foreign('counterzonetype_id')->references('id')->on('counter_zone_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarifs', function (Blueprint $table) {
            //
        });
    }
};
