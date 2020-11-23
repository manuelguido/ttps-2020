<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\System;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newUserList = [
            [
                'name' => 'Juan',
                'lastname' => 'Perez',
                'email' => 'admin1@gmail.com',
                'role' => Role::ROLE_ADMIN,
            ],
            [
                'name' => 'Ana',
                'lastname' => 'Lopez',
                'email' => 'admin2@gmail.com',
                'role' => Role::ROLE_ADMIN,
            ],
            [
                'name' => 'Juana',
                'lastname' => 'Mendez',
                'email' => 'medico1@gmail.com',
                'role' => Role::ROLE_MEDIC,
                'system' => System::SYSTEM_GUARD,
            ],
            [
                'name' => 'Mirta',
                'lastname' => 'Lopez',
                'email' => 'medico2@gmail.com',
                'role' => Role::ROLE_MEDIC,
                'system' => System::SYSTEM_GUARD,
            ],
            [
                'name' => 'Agustin',
                'lastname' => 'Mendez',
                'email' => 'medico3@gmail.com',
                'role' => Role::ROLE_MEDIC,
                'system' => System::SYSTEM_GUARD,
            ],
            [
                'name' => 'Juan',
                'lastname' => 'Gutierrez',
                'email' => 'medico4@gmail.com',
                'role' => Role::ROLE_MEDIC,
                'system' => System::SYSTEM_COVID_FLOOR,
            ],
            [
                'name' => 'Ana',
                'lastname' => 'Gutierrez',
                'email' => 'medico5@gmail.com',
                'role' => Role::ROLE_MEDIC,
                'system' => System::SYSTEM_UTI,
            ],
            [
                'name' => 'Laura',
                'lastname' => 'Mendez',
                'email' => 'medico6@gmail.com',
                'role' => Role::ROLE_MEDIC,
                'system' => System::SYSTEM_UTI,
            ],
            [
                'name' => 'Darío',
                'lastname' => 'Benítez',
                'email' => 'medico7@gmail.com',
                'role' => Role::ROLE_MEDIC,
                'system' => System::SYSTEM_UTI,
            ],
            [
                'name' => 'Marcos',
                'lastname' => 'Gonzalez',
                'email' => 'medico8@gmail.com',
                'role' => Role::ROLE_MEDIC,
                'system' => System::SYSTEM_UTI,
            ],
            [
                'name' => 'Mauro',
                'lastname' => 'Boler',
                'email' => 'medico9@gmail.com',
                'role' => Role::ROLE_MEDIC,
                'system' => System::SYSTEM_HOTEL,
            ],
            [
                'name' => 'Denise',
                'lastname' => 'Baston',
                'email' => 'medico10@gmail.com',
                'role' => Role::ROLE_MEDIC,
                'system' => System::SYSTEM_HOME,
            ],
            [
                'name' => 'María',
                'lastname' => 'Lopez',
                'email' => 'configurador@gmail.com',
                'role' => Role::ROLE_RULE_SETTER,
            ],
            [
                'name' => 'Grupo',
                'lastname' => '7',
                'email' => 'ttps2020.grupo7@gmail.com',
                'role' => Role::ROLE_ADMIN,
            ],
            [
                'name' => 'Juan',
                'lastname' => 'Lopez',
                'email' => 'jefe_guardia@gmail.com',
                'role' => Role::ROLE_SYSTEM_CHIEF,
                'system' => System::SYSTEM_GUARD,
            ],
            [
                'name' => 'Maria',
                'lastname' => 'Mendez',
                'email' => 'jefe_piso_covid@gmail.com',
                'role' => Role::ROLE_SYSTEM_CHIEF,
                'system' => System::SYSTEM_COVID_FLOOR,
            ],
            [
                'name' => 'Mirta',
                'lastname' => 'Gutierrez',
                'email' => 'jefe_uti@gmail.com',
                'role' => Role::ROLE_SYSTEM_CHIEF,
                'system' => System::SYSTEM_UTI,
            ],
            [
                'name' => 'Nadia',
                'lastname' => 'Lopez',
                'email' => 'jefe_hotel@gmail.com',
                'role' => Role::ROLE_SYSTEM_CHIEF,
                'system' => System::SYSTEM_HOTEL,
            ],
            [
                'name' => 'Carlos',
                'lastname' => 'Perez',
                'email' => 'jefe_domicilio@gmail.com',
                'role' => Role::ROLE_SYSTEM_CHIEF,
                'system' => System::SYSTEM_HOME,
            ],
        ];

        /**
         * Creacion de usuarios
         */
        foreach ($newUserList as $newUserData) {
            $newUserData['password'] = 'ttpscovid';
            $newUserData['phone'] = mt_rand(1000000, 99999999);
            $newUserData['dni'] = mt_rand(1000000, 99999999);

            $user = User::create($newUserData);
            $user->setRole($newUserData['role']);
            if ($newUserData['role'] == Role::ROLE_MEDIC || $newUserData['role'] == Role::ROLE_SYSTEM_CHIEF)
            {
                $user->setSystem($newUserData['system']);
            }
        }
    }
}
