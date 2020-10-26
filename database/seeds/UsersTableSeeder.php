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
         * Creacion de administradores
         */
        $admin = newUser('admin1@gmail.com', 'password', 'Juan', 'Perez');
        $admin->setRole(Role::ROLE_ADMIN);

        $admin = newUser('admin2@gmail.com', 'password', 'Ana', 'Lopez');
        $admin->setRole(Role::ROLE_ADMIN);


        /**
         * Creacion de médicos
         */
        $medic = newUser('medico1@gmail.com', 'password', 'Juana', 'Mendez');
        $medic->setRole(Role::ROLE_MEDIC);
        $medic->setSystem(System::SYSTEM_GUARD);

        $medic = newUser('medico2@gmail.com', 'password', 'Mirta', 'López');
        $medic->setRole(Role::ROLE_MEDIC);
        $medic->setSystem(System::SYSTEM_GUARD);

        $medic = newUser('medico3@gmail.com', 'password', 'Agustin', 'Mendez');
        $medic->setRole(Role::ROLE_MEDIC);
        $medic->setSystem(System::SYSTEM_GUARD);

        $medic = newUser('medico4@gmail.com', 'password', 'Juan', 'Gutierrez');
        $medic->setRole(Role::ROLE_MEDIC);
        $medic->setSystem(System::SYSTEM_COVID_FLOOR);

        $medic = newUser('medico5@gmail.com', 'password', 'Ana', 'Gutierrez');
        $medic->setRole(Role::ROLE_MEDIC);
        $medic->setSystem(System::SYSTEM_UTI);

        $medic = newUser('medico6@gmail.com', 'password', 'Laura', 'Mendez');
        $medic->setRole(Role::ROLE_MEDIC);
        $medic->setSystem(System::SYSTEM_UTI);

        $medic = newUser('medico7@gmail.com', 'password', 'Darío', 'Benítez');
        $medic->setRole(Role::ROLE_MEDIC);
        $medic->setSystem(System::SYSTEM_UTI);

        $medic = newUser('medico8@gmail.com', 'password', 'Marcos', 'Gonzalez');
        $medic->setRole(Role::ROLE_MEDIC);
        $medic->setSystem(System::SYSTEM_UTI);

        $medic = newUser('medico9@gmail.com', 'password', 'Mauro', 'Boler');
        $medic->setRole(Role::ROLE_MEDIC);
        $medic->setSystem(System::SYSTEM_HOTEL);

        $medic = newUser('medico10@gmail.com', 'password', 'Denise', 'Baston');
        $medic->setRole(Role::ROLE_MEDIC);
        $medic->setSystem(System::SYSTEM_HOME);

        
        /**
         * Creación de configurador de reglas
         */
        $rule_setter = newUser('configurador@gmail.com', 'password', 'María', 'Lopez');
        $rule_setter->setRole(Role::ROLE_RULE_SETTER);

        /**
         * Creación de administrador con usuario de gmail para gooogle auth
         */
        $admin = newUser('ttps2020.grupo7@gmail.com', 'password', 'Grupo', '7');
        $admin->setRole(Role::ROLE_ADMIN);

        /**
         * Creación de Jefes de sistema
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
