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
        function create_new($name)
        {
            $me = new MedicalEnsurance;
            $me->medical_ensurance = $name;
            $me->save();
        }

        create_new('Swiss Medical');
        create_new('IOMA');
        create_new('Aca Salud');
        create_new('OSDE');
        create_new('OSECAC');
    }
}
