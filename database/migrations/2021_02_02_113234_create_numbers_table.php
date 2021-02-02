<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateNumbersTable
 */
class CreateNumbersTable extends Migration
{
    /**
     * Creates the numbers table.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numbers', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('numeral');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Drops the numbers table.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('numbers');
    }
}
