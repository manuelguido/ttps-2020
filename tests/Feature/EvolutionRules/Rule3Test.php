<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\RuleSettings;
use App\Evolution;


class Rule3 extends TestCase
{
    /**
     * Test de regla 3: Ver que la Frecuencia Respiratoria es mayor a al parámetro.
     *
     * @return void
     */
    public function testExample()
    {
        // Obtener configuración de reglas
        $ruleSettings = RuleSettings::find(1);        
        $ruleSettings->breathing_rate = 20;
        $ruleSettings->save();

        // Creación de evolución
        $evolution = factory(Evolution::class)->create();

        /**
         * Testeo de regla cuando el paciente frecuencia respiratoria mayor al parámetro
         */
        $evolution->breathing_rate = 21; // 21 > 20
        $ruleCondition = $ruleSettings->analizeRule3($evolution);
        $this->assertTrue($ruleCondition);

        /**
         * Testeo de regla cuando el paciente frecuencia respiratoria menor al parámetro
         */
        $evolution->breathing_rate = 17;  // 17 < 20
        $ruleCondition = $ruleSettings->analizeRule3($evolution);
        $this->assertFalse($ruleCondition);

        /**
         * Borrado de información de test en DB
         */
        $evolution->delete();
    }
}
