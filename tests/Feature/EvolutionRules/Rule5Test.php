<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\RuleSettings;
use App\Evolution;


class Rule5 extends TestCase
{
    /**
     * Test de regla 5: Ver que la Saturación de Oxígeno es menor al parámetro.
     *
     * @return void
     */
    public function testExample()
    {
        // Obtener configuración de reglas
        $ruleSettings = RuleSettings::find(1);        
        $ruleSettings->oxigen_saturation = 92;
        $ruleSettings->save();

        // Creación de evolución
        $evolution = factory(Evolution::class)->create();

        /**
         * Testeo de regla cuando la saturación de oxígeno es menor al parámetro
         */
        $evolution->oxigen_saturation = 91; // 91 < 92
        $ruleCondition = $ruleSettings->analizeRule5($evolution);
        $this->assertTrue($ruleCondition);

        /**
         * Testeo de regla cuando la saturación de oxígeno es mayor al parámetro
         */
        $evolution->oxigen_saturation = 94; // 94 > 92
        $ruleCondition = $ruleSettings->analizeRule5($evolution);
        $this->assertFalse($ruleCondition);

        /**
         * Testeo de regla cuando la saturación de oxígeno es igual al parámetro
         */
        $evolution->oxigen_saturation = 92; // 92 == 92
        $ruleCondition = $ruleSettings->analizeRule5($evolution);
        $this->assertFalse($ruleCondition);

        /**
         * Testeo de regla cuando la saturación de oxígeno es nula, dado que no se registro ningun dato
         */
        $evolution->oxigen_saturation = null; // nulo
        $ruleCondition = $ruleSettings->analizeRule5($evolution);
        $this->assertFalse($ruleCondition);

        /**
         * Borrado de información de test en DB
         */
        $evolution->delete();
    }
}
