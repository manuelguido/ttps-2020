<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitalizations', function (Blueprint $table) {
            $table->bigIncrements('hospitalization_id');
            // Entry id
            $table->unsignedBigInteger('entry_id');
            $table->foreign('entry_id')->references('entry_id')->on('entries');
            // System id
            $table->unsignedBigInteger('system_id')->unique();
            $table->foreign('system_id')->references('system_id')->on('systems');
            $table->string('actual_disease');
            $table->dateTime('date_of_diagnosis');
            $table->dateTime('date_of_admission');
            $table->dateTime('date_of_death')->nullable()->default(NULL);
            $table->dateTime('date_of_exit')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hospitalizations');
    }
}
