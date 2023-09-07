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
        Schema::create('notice_for_owners', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->date('date');
            $table->bigInteger('abonent_id')->unsigned();
            $table->bigInteger('organization_id')->unsigned();
            $table->timestamps();
            $table->foreign('abonent_id')->references('id')->on('abonents');
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
        Schema::dropIfExists('notice_for_owners');
    }
};
