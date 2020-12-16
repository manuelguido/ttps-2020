<?php

use Illuminate\Database\Seeder;
use App\MedicalEnsurance;
use App\PatientState;
use Carbon\Carbon;
use App\Patient;
use App\System;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        function randomName()
        {
            $names = ['Juan', 'Matias', 'Pedro', 'Maria', 'Mabel', 'Mirta', 'Lucrecia', 'Pepe', 'Facundo', 'Dario', 'Sol'];
            return $names[rand(0, count($names) - 1)];
        }

        function randomLastname()
        {
            $lastnames = ['Gomez', 'Lopez', 'Gonzalez', 'Estevez', 'Iriarte'];
            return $lastnames[rand(0, count($lastnames) - 1)];
        }

        function randomEmail($patient)
        {
            $str = $patient->name.$patient->lastname.rand(100, 999);
            $email_ending = '@gmail.com';
            return mb_strtolower($str).$email_ending;
        }

        $guardSystem = System::find(1);

        for ($i=0; $i < 20; $i++)
        { 
            $patient = new Patient;
            $patient->name = randomName();
            $patient->lastname = randomLastname();
            $patient->dni = rand(10000000, 50000000);
            $patient->address = 'Calle '.rand(10, 140).', nro '.rand(100, 3000);
            $patient->phone = rand(10000000, 50000000);
            $patient->birth_date = date("Y-m-d H:i:s",mt_rand(1262055681,1262055681));
            $patient->personal_background = '';
            $patient->medical_ensurance_id = MedicalEnsurance::find(mt_rand(1,4))->medical_ensurance_id;
            $patient->patient_state_id = PatientState::find(1)->patient_state_id;
            $patient->system_id = $guardSystem->system_id;
            $patient->email = randomEmail($patient);
            $patient->contact_name = randomName();
            $patient->contact_lastname = randomLastname();
            $patient->contact_phone = rand(10000000, 50000000);
            $patient->save();
            $patient->addEntry([
                'patient_id' => $patient->patient_id,
                'actual_disease' => 'Covid',
                'date_of_symptoms' => Carbon::now('America/Argentina/Buenos_Aires'),
                'date_of_diagnosis' => Carbon::now('America/Argentina/Buenos_Aires'),
                'date_of_admission' => Carbon::now('America/Argentina/Buenos_Aires'),
                'date_of_death' => null,
                'date_of_exit' => null,
            ]);
            $patient->addHospitalization();
        }
    }
}
