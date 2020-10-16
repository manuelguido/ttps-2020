<?php

use Illuminate\Database\Seeder;
use App\PatientState;

class PatientStatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        function new_patient_state($name)
        {
            $state = new PatientState;
            $state->patient_state = $name;
            $state->save();
            return $state;
        }

        new_patient_state(PatientState::STATE_HOSPITALIZED);
        new_patient_state(PatientState::STATE_DISCHARGED);
        new_patient_state(PatientState::STATE_DEATH);
    }
}
