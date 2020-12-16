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
     * Test de regla 2 (Ver paciente tiene mecánica ventilatoria "Regular" o "Mala")
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
        // Obtener id de mecánicas respiratorias
        $vm_good_id = VentilatoryMechanic::getIdByName(VentilatoryMechanic::GOOD);
        $vm_regular_id = VentilatoryMechanic::getIdByName(VentilatoryMechanic::REGULAR);
        $vm_bad_id = VentilatoryMechanic::getIdByName(VentilatoryMechanic::BAD);


        // Mecánica respiratoria buena -> regla es false
        $evolution->ventilatory_mechanic_id = $vm_good_id;
        $ruleCondition = $ruleSettings->analizeRule2($evolution);
        $this->assertFalse($ruleCondition);

        // Mecánica respiratoria regular -> regla es true
        $evolution->ventilatory_mechanic_id = $vm_regular_id;
        $ruleCondition = $ruleSettings->analizeRule2($evolution);
        $this->assertTrue($ruleCondition);

        // Mecánica respiratoria mala -> regla es true
        $evolution->ventilatory_mechanic_id = $vm_bad_id;
        $ruleCondition = $ruleSettings->analizeRule2($evolution);
        $this->assertTrue($ruleCondition);

        // Borrado de información de test
        $evolution->delete();
        $hospitalization->delete();
        $entry->delete();
        $patient->delete();
        $user->delete();
    }
}
