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
        function new_user($email, $password, $name, $lastname)
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
        function new_medic($user_id)
        {
            $medic = new Medic;
            $medic->user_id = $user_id;
            $medic->save();
        }

        // Creacion de administrador
        $admin = new_user('admin@gmail.com', 'password', 'Nombre', 'Admin');
        $admin->set_role(Role::ROLE_ADMIN);

        // Creación de médico
        $medic = new_user('medico@gmail.com', 'password', 'Nombre', 'Médico');
        $medic->set_role(Role::ROLE_MEDIC);
        new_medic($medic->user_id);

        // Creación de configurador de reglas
        $rule_setter = new_user('configurador@gmail.com', 'password', 'Nombre', 'C. de Reglas');
        $rule_setter->set_role(Role::ROLE_RULE_SETTER);

        // Creacion de administrador
        $admin = new_user('manuelguido.m@gmail.com', 'password', 'Manuel', 'Guido');
        $admin->set_role(Role::ROLE_ADMIN);

        /**
         * Jefes de sistema
         */
        // Creacion de jefe de sistema (Guardia)
        $system_chief = new_user('jefe_guardia@gmail.com', 'password', 'Nombre', 'J.S. Guardia');
        $system_chief->set_role(Role::ROLE_SYSTEM_CHIEF);
        $system_chief->set_system(System::SYSTEM_GUARD);

        // Creacion de jefe de sistema (Piso Covid)
        $system_chief = new_user('jefe_piso_covid@gmail.com', 'password', 'Nombre', 'J.S. Piso covid');
        $system_chief->set_role(Role::ROLE_SYSTEM_CHIEF);
        $system_chief->set_system(System::SYSTEM_GUARD);
        
        // Creacion de jefe de sistema (UTI)
        $system_chief = new_user('jefe_uti@gmail.com', 'password', 'Nombre', 'J.S. UTI');
        $system_chief->set_role(Role::ROLE_SYSTEM_CHIEF);
        $system_chief->set_system(System::SYSTEM_GUARD);

        // Creacion de jefe de sistema (Hotel)
        $system_chief = new_user('jefe_hotel@gmail.com', 'password', 'Nombre', 'J.S. Hotel');
        $system_chief->set_role(Role::ROLE_SYSTEM_CHIEF);
        $system_chief->set_system(System::SYSTEM_GUARD);

        // Creacion de jefe de sistema (Domicilio)
        $system_chief = new_user('jefe_domicilio@gmail.com', 'password', 'Nombre', 'J.S. Domicilio');
        $system_chief->set_role(Role::ROLE_SYSTEM_CHIEF);
        $system_chief->set_system(System::SYSTEM_GUARD);
    }
}
