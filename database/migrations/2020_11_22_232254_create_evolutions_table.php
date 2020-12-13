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
            $table->timestamps();
            // Id de la hospitalización correspondiente
            $table->unsignedBigInteger('hospitalization_id');
            $table->foreign('hospitalization_id')->references('hospitalization_id')->on('hospitalizations');
            // Id de usuario que creo la hospitalización
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');

            // Step 1 de evolución
            $table->double('temperature', 3, 1); // 3 digitos, 1 decimal
            $table->integer('heart_rate');
            $table->integer('breathing_rate');
            $table->integer('systolic_ta');
            $table->integer('diastolic_ta');

            // Step 2 de evolución
            $table->unsignedBigInteger('ventilatory_mechanic_id')->nullable()->default(null);
            $table->foreign('ventilatory_mechanic_id')->references('ventilatory_mechanic_id')->on('ventilatory_mechanics');
            $table->boolean('requires_oxigen')->default(false);
            $table->unsignedBigInteger('oxigen_requirement_type_id')->nullable()->default(null);
            $table->foreign('oxigen_requirement_type_id')->references('oxigen_requirement_type_id')->on('oxigen_requirement_types');
            $table->integer('oxigen_requirement_value')->nullable()->default(null);
            $table->integer('oxigen_saturation')->nullable()->default(null);

            $table->boolean('pafi')->default(false);
            $table->integer('pafi_value')->nullable()->default(null);
            $table->boolean('prone')->default(false);
            $table->boolean('cough')->default(false);
            $table->integer('dyspnoea')->nullable()->default(null);
            $table->boolean('respiratory_irregularities')->default(false);
            
            // Step 3 de evolución
            $table->boolean('drowsiness')->default(false);
            $table->boolean('anosmia')->default(false);
            $table->boolean('dysgeucia')->default(false);

            // Step 4 de evolución
            $table->boolean('rxtx')->default(false);
            $table->integer('rxtx_type')->nullable()->default(null);
            $table->text('rxtx_text')->nullable()->default(null);
            $table->boolean('tac')->default(false);
            $table->integer('tac_type')->nullable()->default(null);
            $table->text('tac_text')->nullable()->default(null);
            $table->boolean('ecg')->default(false);
            $table->integer('ecg_type')->nullable()->default(null);
            $table->text('ecg_text')->nullable()->default(null);
            $table->boolean('pcr')->default(false);
            $table->integer('pcr_type')->nullable()->default(null);
            $table->text('pcr_text')->nullable()->default(null);
            $table->boolean('laboratory')->default(false);

            // Step 4 de evolución
            $table->unsignedBigInteger('feeding_type_id')->nullable()->default(null);
            $table->foreign('feeding_type_id')->references('feeding_type_id')->on('feeding_types');
            $table->text('feeding_note')->nullable()->default(null);
            $table->text('drug')->nullable()->default(null);
            $table->text('drug_dosis')->nullable()->default(null);
            $table->integer('dosis_day_number')->nullable()->default(null);
            
            $table->boolean('thromboprophylaxis')->default(false);
            $table->text('thromboprophylaxis_data')->nullable()->default(null);
            
            $table->boolean('dexamethasone')->default(false);
            $table->text('dexamethasone_data')->nullable()->default(null);
            
            $table->boolean('gastric_protection')->default(false);
            $table->text('gastric_protection_data')->nullable()->default(null);
            
            $table->boolean('dialysis')->default(false);
            $table->text('dialysis_data')->nullable()->default(null);
            
            $table->boolean('research_study')->default(false);
            $table->text('research_study_data')->nullable()->default(null);

            // Step 6 de evolución
            $table->text('observations')->nullable()->default(null);    
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
