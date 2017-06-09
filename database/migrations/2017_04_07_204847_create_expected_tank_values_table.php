<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpectedTankValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expected_tank_values', function (Blueprint $table) {
            $table->integer('IDNum')->unsigned()->unique();
            $table->string('name')->default('xxx_xxx');
            $table->decimal('expFrag', 8, 2);
            $table->decimal('expDamage', 8, 2);
            $table->decimal('expSpot', 8, 2);
            $table->decimal('expDef', 8, 2);
            $table->decimal('expWinRate', 5, 2);
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
        Schema::dropIfExists('expected_tank_values');
    }
}
