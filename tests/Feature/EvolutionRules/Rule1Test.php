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
use App\Alert;
use App\User;
use DB;

class Rule1 extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        // Obtener configuración de reglas
        $ruleSettings = RuleSettings::find(1);        

        // Creación de usuario
        $user = factory(User::class)->create(); // Creo un usuario
        
        // Creación de paciente
        $patient = factory(Patient::class)->create();
        
        // Creación de entrada al sistema
        $entry = factory(Entry::class)->create();
        $entry->patient_id = $patient->patient_id;
        $entry->save();

        // Creación de hospitalización
        $hospitalization = factory(Hospitalization::class)->create();
        $hospitalization->entry_id = $entry->entry_id;
        $hospitalization->save();
        
        // Creación de evolución
        $evolution = factory(Evolution::class)->create();
        $evolution->hospitalization_id = $hospitalization->hospitalization_id;
        $evolution->save();

        /**
         * Testeo de regla numero 1
         * 
         * Si somnolencia es true, la funcion debe retornar verdadero, para evaluar el pase a uti.
         */
        $evolution->drowsiness = true; // Somnolencia es "true"
        $ruleCondition = $ruleSettings->analizeRule1($evolution); // Evaluar regla
        $this->assertTrue($ruleCondition); // Ver que la regla devuelve "true"

        $evolution->drowsiness = false; // Somnolencia es "false"
        $ruleCondition = $ruleSettings->analizeRule1($evolution); // Evaluar regla
        $this->assertFalse($ruleCondition); // Ver que la regla devuelve "false"

        // Borrado de información de test
        $evolution->delete();
        $hospitalization->delete();
        $entry->delete();
        $patient->delete();
        $user->delete();
    }
}
