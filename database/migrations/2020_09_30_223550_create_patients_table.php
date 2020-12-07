<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('patient_id');
            $table->timestamps();
            $table->string('name');
            $table->string('lastname');
            $table->string('address');
            $table->bigInteger('phone');
            $table->bigInteger('dni')->unique();
            $table->date('birth_date');
            $table->mediumText('personal_background')->nullable();
            $table->unsignedBigInteger('medical_ensurance_id');
            $table->foreign('medical_ensurance_id')->references('medical_ensurance_id')->on('medical_ensurances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
