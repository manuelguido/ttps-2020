<?php

use Illuminate\Database\Seeder;
use App\System;

class SystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        function create_system($name)
        {
            $system = new System;
            $system->system = $name;
            $system->save();
        }

        create_system('Guardia');
        create_system('Piso covid');
        create_system('UTI');
        create_system('Hotel');
        create_system('Domicilio');
    }
}
