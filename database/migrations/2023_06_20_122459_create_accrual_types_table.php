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
        Schema::create('accrual_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('by_counter');
            $table->timestamps();
        });
        DB::table('accrual_types')->insert([
            ['id' => 1, 'name' => 'Electricity', 'by_counter' => 1],
            ['id' => 2, 'name' => 'Gas', 'by_counter' => 1],
            ['id' => 3, 'name' => 'Water', 'by_counter' => 1],
            ['id' => 4, 'name' => 'Membership contribution', 'by_counter' => 0],
            ['id' => 5, 'name' => 'Earmarked contribution', 'by_counter' => 0],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accrual_types');
    }
};
