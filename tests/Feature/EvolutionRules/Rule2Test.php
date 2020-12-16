<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Carbon;
use App\VentilatoryMechanic;
use App\Hospitalization;
use App\RuleSettings;
use App\Evolution;
use App\Patient;
use App\Entry;
use App\User;
use DB;

class Rule2 extends TestCase
{
    /**
     * Test de regla 2: Ver paciente tiene mecánica ventilatoria "Regular" o "Mala".
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
         * Testeo de regla cuando el paciente tiene mecánica respiratoria BUENA
         */
        $vm_good_id = VentilatoryMechanic::getIdByName(VentilatoryMechanic::GOOD);
        
        $evolution->ventilatory_mechanic_id = $vm_good_id;
        
        $ruleCondition = $ruleSettings->analizeRule2($evolution);
        
        $this->assertFalse($ruleCondition);

        /**
         * Testeo de regla cuando el paciente tiene mecánica respiratoria REGULAR
         */
        $vm_regular_id = VentilatoryMechanic::getIdByName(VentilatoryMechanic::REGULAR);

        $evolution->ventilatory_mechanic_id = $vm_regular_id;
        
        $ruleCondition = $ruleSettings->analizeRule2($evolution);
        
        $this->assertTrue($ruleCondition);

        /**
         * Testeo de regla cuando el paciente tiene mecánica respiratoria MALA
         */
        $vm_bad_id = VentilatoryMechanic::getIdByName(VentilatoryMechanic::BAD);

        $evolution->ventilatory_mechanic_id = $vm_bad_id;
        
        $ruleCondition = $ruleSettings->analizeRule2($evolution);
        
        $this->assertTrue($ruleCondition);

        /**
         * Borrado de información de test en DB
         */
        $evolution->delete();
    }
}
