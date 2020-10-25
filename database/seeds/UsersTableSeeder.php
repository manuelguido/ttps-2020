<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\System;
use App\Medic;
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
        /**
         * Nuevo usuario
         */
        function newUser($email, $password, $name, $lastname)
        {
            $user = new User;
            $user->name = $name;
            $user->lastname = $lastname;
            $user->email = $email;
            $user->phone = mt_rand(1000000, 99999999);
            $user->dni = mt_rand(1000000, 99999999);
            $user->password = bcrypt($password);
            $user->save();
            return $user;
        }

        /**
         * Nuevo médico
         */
        function newMedic($user_id)
        {
            $medic = new Medic;
            $medic->user_id = $user_id;
            $medic->save();
        }

        // Creacion de administrador
        $admin = newUser('admin@gmail.com', 'password', 'Juan', 'Perez');
        $admin->setRole(Role::ROLE_ADMIN);

        // Creación de médico
        $medic = newUser('medico@gmail.com', 'password', 'Juana', 'Mendez');
        $medic->setRole(Role::ROLE_MEDIC);
        newMedic($medic->user_id);

        // Creación de configurador de reglas
        $rule_setter = newUser('configurador@gmail.com', 'password', 'María', 'Lopez');
        $rule_setter->setRole(Role::ROLE_RULE_SETTER);

        // Creacion de administrador
        $admin = newUser('ttps2020.grupo7@gmail.com', 'password', 'Grupo', '7');
        $admin->setRole(Role::ROLE_ADMIN);

        /**
         * Jefes de sistema
         */
        // Creacion de jefe de sistema (Guardia)
        $system_chief = newUser('jefe_guardia@gmail.com', 'password', 'Juan', 'Lopez');
        $system_chief->setRole(Role::ROLE_SYSTEM_CHIEF);
        $system_chief->setSystem(System::SYSTEM_GUARD);

        // Creacion de jefe de sistema (Piso Covid)
        $system_chief = newUser('jefe_piso_covid@gmail.com', 'password', 'Maria', 'Mendez');
        $system_chief->setRole(Role::ROLE_SYSTEM_CHIEF);
        $system_chief->setSystem(System::SYSTEM_COVID_FLOOR);
        
        // Creacion de jefe de sistema (UTI)
        $system_chief = newUser('jefe_uti@gmail.com', 'password', 'Mirta', 'Gutierrez');
        $system_chief->setRole(Role::ROLE_SYSTEM_CHIEF);
        $system_chief->setSystem(System::SYSTEM_UTI);

        // Creacion de jefe de sistema (Hotel)
        $system_chief = newUser('jefe_hotel@gmail.com', 'password', 'Nadia', 'Lopez');
        $system_chief->setRole(Role::ROLE_SYSTEM_CHIEF);
        $system_chief->setSystem(System::SYSTEM_HOTEL);

        // Creacion de jefe de sistema (Domicilio)
        $system_chief = newUser('jefe_domicilio@gmail.com', 'password', 'Carlos', 'Perez');
        $system_chief->setRole(Role::ROLE_SYSTEM_CHIEF);
        $system_chief->setSystem(System::SYSTEM_HOME);
    }
}
