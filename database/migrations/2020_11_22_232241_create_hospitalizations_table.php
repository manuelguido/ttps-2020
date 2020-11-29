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
            $table->unsignedBigInteger('system_id');
            $table->foreign('system_id')->references('system_id')->on('systems');
            // Previous system id
            $table->unsignedBigInteger('previous_system_id')->nullable()->default(NULL);
            $table->foreign('previous_system_id')->references('system_id')->on('systems');

            $table->timestamp('date_of_admission')->nullable()->default(NULL);
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
        Schema::dropIfExists('hospitalizations');
    }
}
