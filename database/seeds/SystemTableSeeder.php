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

        create_system(System::SYSTEM_GUARD);
        create_system(System::SYSTEM_COVID_FLOOR);
        create_system(System::SYSTEM_UTI);
        create_system(System::SYSTEM_HOTEL);
        create_system(System::SYSTEM_HOME);
    }
}
