<?php

use Illuminate\Database\Seeder;
use App\MedicalEnsurance;
use App\PatientState;
use App\Patient;
use App\System;
use Carbon\Carbon;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newPatientList = [
            [
                'name' => 'Juan',
                'lastname' => 'Perez', 
            ],
            [
                'name' => 'Maria',
                'lastname' => 'Perez', 
            ],
            [
                'name' => 'Pedro',
                'lastname' => 'Gomez', 
            ],
            [
                'name' => 'Mirta',
                'lastname' => 'Estevez', 
            ],
        ];

        /**
         * Creacion de usuarios
         */
        foreach ($newPatientList as $newPatientData) {
            $patient = new Patient;
            $patient->name = $newPatientData['name'];
            $patient->lastname = $newPatientData['lastname'];
            $patient->dni = rand(10000000, 50000000);
            $patient->address = 'Calle '.rand(10, 140).', nro '.rand(100, 3000);
            $patient->phone = rand(10000000, 50000000);
            $patient->birth_date = date("Y-m-d H:i:s",mt_rand(1262055681,1262055681));
            $patient->personal_background = '';
            $patient->family_data = '';
            $patient->medical_ensurance_id = MedicalEnsurance::find(mt_rand(1,4))->medical_ensurance_id;
            $patient->patient_state_id = PatientState::find(1)->patient_state_id;
            $patient->system_id = System::find(1)->system_id;
            $patient->save();
            $patient->setNewSystemById(System::find(1)->system_id);

            $entryData = [
                'actual_disease' => Carbon::now('America/Argentina/Buenos_Aires'),
                'date_of_symptoms' => Carbon::now('America/Argentina/Buenos_Aires'),
                'date_of_diagnosis' => Carbon::now('America/Argentina/Buenos_Aires'),
                'date_of_admission' => Carbon::now('America/Argentina/Buenos_Aires'),
                'date_of_death' => NULL,
                'date_of_exit' => NULL,
            ];

            $patient->addEntry($entryData);
        }
    }
}
