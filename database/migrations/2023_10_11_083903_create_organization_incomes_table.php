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
        Schema::create('organization_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('value');
            $table->date('date');
            $table->bigInteger('organization_id')->unsigned();
            $table->bigInteger('budgetitemtype_id')->unsigned();
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('budgetitemtype_id')->references('id')->on('budget_item_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_incomes');
    }
};
