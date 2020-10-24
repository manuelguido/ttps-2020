<?php

use Illuminate\Database\Seeder;
use App\MedicalEnsurance;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        function new_patient($name, $lastname)
        {
            $patient = new Patient;
            $patient->name = $name;
            $patient->lastname = $lastname;
            $patient->address = 'Calle '+rand(10, 140)+', nro '+rand(100, 3000);
            $patient->phone = $dni;
            $patient->dni = rand(10000000, 50000000);
            $patient->birth_date = date("Y-m-d H:i:s",mt_rand(1262055681,1262055681));
            $patient->personal_background = '';
            $patient->medical_ensurance_id = MedicalEnsurance::find(mt_rand(1,4))->medical_ensurance_id;
            return $patient;
        }

        new_patient('Juan', 'Perez');
        new_patient('Maria', 'Perez');
        new_patient('Pedro', 'Gomez');
        new_patient('Mirta', 'Estevez');
    }
}
