<?php

use Illuminate\Database\Seeder;
use App\MedicalEnsurance;

class MedicalEnsuranceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MedicalEnsurance::createMedicalEnsurance('Swiss Medical');
        MedicalEnsurance::createMedicalEnsurance('IOMA');
        MedicalEnsurance::createMedicalEnsurance('Aca Salud');
        MedicalEnsurance::createMedicalEnsurance('OSDE');
        MedicalEnsurance::createMedicalEnsurance('OSECAC');
    }
}
