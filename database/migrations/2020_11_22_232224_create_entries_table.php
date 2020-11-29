<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->bigIncrements('entry_id');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
            $table->timestamp('date');
            $table->time('time');
            $table->string('actual_disease');
            $table->timestamp('date_of_symptoms')->nullable()->default(NULL);
            $table->timestamp('date_of_diagnosis')->nullable()->default(NULL);
            $table->timestamp('date_of_admission')->nullable()->default(NULL);
            $table->timestamp('date_of_death')->nullable()->default(NULL);
            $table->timestamp('date_of_exit')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entries');
    }
}
