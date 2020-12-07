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
        function newPatientState($name)
        {
            $state = new PatientState;
            $state->patient_state = $name;
            $state->save();
            return $state;
        }

        newPatientState(PatientState::STATE_HOSPITALIZED);
        newPatientState(PatientState::STATE_DISCHARGED);
        newPatientState(PatientState::STATE_DEATH);
    }
}
