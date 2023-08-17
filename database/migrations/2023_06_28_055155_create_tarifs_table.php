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
        Schema::create('tarifs', function (Blueprint $table) {
            $table->id();
            $table->double('value');
            $table->date('date_begin');
            $table->date('date_end')->nullable();
            $table->bigInteger('organization_id')->unsigned();
            $table->bigInteger('accrualtype_id')->unsigned();
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('accrualtype_id')->references('id')->on('accrual_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarifs');
    }
};
