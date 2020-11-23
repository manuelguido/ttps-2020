<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evolutions', function (Blueprint $table) {
            $table->bigIncrements('evolution_id');
            // Entry id
            $table->unsignedBigInteger('hospitalization_id');
            $table->foreign('hospitalization_id')->references('hospitalization_id')->on('hospitalizations');
            $table->date('date');
            $table->string('vital_signs');
            $table->string('respiratory_system');
            $table->string('other_sintoms');
            $table->string('studies_of_the_day');
            $table->string('current_treatments');
            $table->string('observations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evolutions');
    }
}
