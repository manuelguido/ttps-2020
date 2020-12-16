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
use App\User;
use DB;

class Rule1 extends TestCase
{
    /**
     * Test de regla 1: Somnolencia
     * 
     * @return void
     */
    public function testExample()
    {
        // Obtener configuración de reglas
        $ruleSettings = RuleSettings::find(1);        
        
        // Creación de evolución
        $evolution = factory(Evolution::class)->create();

        /**
         * Testeo de regla cuando el paciente tiene somnolencia
         */
        $evolution->drowsiness = true; // Somnolencia es "true"
        
        $ruleCondition = $ruleSettings->analizeRule1($evolution); // Evaluar regla
        
        $this->assertTrue($ruleCondition); // Ver que la regla devuelve "true"

        /**
         * Testeo de regla cuando el paciente tiene somnolencia
         */
        $evolution->drowsiness = false; // Somnolencia es "false"

        $ruleCondition = $ruleSettings->analizeRule1($evolution); // Evaluar regla
        
        $this->assertFalse($ruleCondition); // Ver que la regla devuelve "false"

        /**
         * Borrado de información de test en DB
         */
        $evolution->delete();
    }
}
