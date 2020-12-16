<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Carbon;
use App\Hospitalization;
use App\RuleSettings;
use App\Evolution;
use App\Patient;
use App\Entry;

class Rule6 extends TestCase
{
    /**
     * Test de regla 6: Ver si la saturación de oxígeno disminuyó un X %.
     * 
     * x: Parámetro
     * 
     * @return void
     */
    public function testExample()
    {
        // Obtener configuración de reglas
        $ruleSettings = RuleSettings::find(1);        

        // Creación de paciente
        $patient = factory(Patient::class)->create();
        
        // Creación de entrada al sistema
        $entry = factory(Entry::class)->create();
        $entry->patient_id = $patient->patient_id;
        $entry->save();

        // Creación de hospitalización al sistema
        $hospitalization = factory(Hospitalization::class)->create();
        $hospitalization->entry_id = $entry->entry_id;
        $hospitalization->save();
        
        // Creación de evolución previa
        $previousEvolution = factory(Evolution::class)->create();
        $previousEvolution->hospitalization_id = $hospitalization->hospitalization_id;
        $previousEvolution->created_at = Carbon::createFromFormat('Y-m-d H:i:s', '2020-12-01 11:53:20');
        $previousEvolution->save();

        // Creación de evolución nueva
        $evolution = factory(Evolution::class)->create();
        $evolution->hospitalization_id = $hospitalization->hospitalization_id;
        $evolution->created_at = Carbon::createFromFormat('Y-m-d H:i:s', '2020-12-04 11:53:20');
        $evolution->save();

        /**
         * Testeo de regla cuando disminuyo mas del parámetro (Ej 3%)
         */
        $ruleSettings->oxigen_saturation_down_percentage = 3;
        $ruleSettings->save();

        $previousEvolution->oxigen_saturation = 98;
        $previousEvolution->save();

        $evolution->oxigen_saturation = 94;
        $evolution->save();

        $ruleCondition = $ruleSettings->analizeRule6($patient, $evolution);
        
        $this->assertTrue($ruleCondition);

        /**
         * Testeo de regla cuando no disminuyo mas del parámetro (Ej 4%)
         */
        $ruleSettings->oxigen_saturation_down_percentage = 4;
        $ruleSettings->save();

        $previousEvolution->oxigen_saturation = 96;
        $previousEvolution->save();

        $evolution->oxigen_saturation = 94;
        $evolution->save();

        $ruleCondition = $ruleSettings->analizeRule6($patient, $evolution);
        
        $this->assertFalse($ruleCondition);

        /**
         * Testeo de regla cuando disminuyo exactamente el (Ej 3%)
         */
        $ruleSettings->oxigen_saturation_down_percentage = 3;
        $ruleSettings->save();

        $previousEvolution->oxigen_saturation = 98;
        $previousEvolution->save();

        $evolution->oxigen_saturation = 94;
        $evolution->save();

        $ruleCondition = $ruleSettings->analizeRule6($patient, $evolution);
        
        $this->assertTrue($ruleCondition);

        /**
         * Testeo de regla cuando el valor de evolución prévia es nulo.
         */
        $ruleSettings->oxigen_saturation_down_percentage = 3;
        $ruleSettings->save();

        $previousEvolution->oxigen_saturation = null;
        $previousEvolution->save();

        $evolution->oxigen_saturation = 94;
        $evolution->save();

        $ruleCondition = $ruleSettings->analizeRule6($patient, $evolution);
        
        $this->assertFalse($ruleCondition);

        /**
         * Testeo de regla cuando el valor de evolución actual es nulo.
         */
        $ruleSettings->oxigen_saturation_down_percentage = 3;
        $ruleSettings->save();

        $previousEvolution->oxigen_saturation = 95;
        $previousEvolution->save();

        $evolution->oxigen_saturation = null;
        $evolution->save();

        $ruleCondition = $ruleSettings->analizeRule6($patient, $evolution);
        
        $this->assertFalse($ruleCondition);

        /**
         * Borrado de información de test en DB
         */
        $evolution->delete();
        $previousEvolution->delete();
        $hospitalization->delete();
        $entry->delete();
        $patient->delete();
    }
}
