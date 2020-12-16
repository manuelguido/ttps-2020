<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Carbon;
use App\RuleSettings;
use App\Evolution;
use App\Patient;
use App\Entry;

class Rule4 extends TestCase
{
    /**
     * Test de regla 4: Pasaron x días desde el inicio de los síntomas.
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
        
        // Creación de evolución
        $evolution = factory(Evolution::class)->create();

        /**
         * Testeo de regla cuando pasaron mas de 10 días
         */
        $ruleSettings->days_to_evaluate = 10;
        $ruleSettings->save();

        $entry->date_of_diagnosis = Carbon::createFromFormat('Y-m-d H:i:s', '2020-12-01 11:53:20');
        $entry->save();

        $evolution->created_at = Carbon::createFromFormat('Y-m-d H:i:s', '2020-12-25 11:53:20');
        $evolution->save();

        $ruleCondition = $ruleSettings->analizeRule4($patient, $evolution); // Evaluar regla
        
        $this->assertTrue($ruleCondition); // Ver que la regla devuelve "false"

        /**
         * Testeo de regla cuando no pasaron mas de 7 días
         */
        $ruleSettings->days_to_evaluate = 7;
        $ruleSettings->save();

        $entry->date_of_diagnosis = Carbon::createFromFormat('Y-m-d H:i:s', '2020-12-01 11:53:20');
        $entry->save();

        $evolution->created_at = Carbon::createFromFormat('Y-m-d H:i:s', '2020-12-05 11:53:20');
        $evolution->save();

        $ruleCondition = $ruleSettings->analizeRule4($patient, $evolution); // Evaluar regla
        
        $this->assertFalse($ruleCondition); // Ver que la regla devuelve "false"

        /**
         * Borrado de información de test en DB
         */
        $evolution->delete();
        $entry->delete();
        $patient->delete();
    }
}
