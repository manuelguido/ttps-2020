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
            $table->timestamp('date');
            $table->time('time');
            $table->double('temperature', 3, 1);
            $table->integer('systolic_ta');
            $table->integer('diastolic');
            $table->integer('fc');
            $table->integer('fr');
            $table->unsignedBigInteger('ventilatory_mechanic_id');
            $table->foreign('ventilatory_mechanic_id')->references('ventilatory_mechanic_id')->on('ventilatory_mechanics');
            $table->boolean('requires_oxigen')->default(false);
            $table->unsignedBigInteger('oxigen_requirement_id');
            $table->foreign('oxigen_requirement_id')->references('oxigen_requirement_id')->on('oxigen_requirements');
            $table->integer('oxigen_saturation');
            $table->boolean('pafi')->default(false);
            $table->integer('pafi_value');
            $table->boolean('prone')->default(false);
            $table->boolean('cough')->default(false);
            $table->integer('dyspnoea')->default(0);
            $table->boolean('respiratory_irregularities')->default(false);
            // $table->text('other_symptoms')->default(false);
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
