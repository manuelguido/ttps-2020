<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        function new_user($email, $password)
        {
            $user = new User;
            $user->name = Str::random(10);
            $user->lastname = Str::random(10);
            $user->email = $email;
            $user->phone = mt_rand(1000000, 99999999);
            $user->dni = mt_rand(1000000, 99999999);
            $user->password = bcrypt($password);
            $user->save();
            return $user;
        }

        function new_medic($user_id)
        {
            $medic = new Medic;
            $medic->user_id = $user_id;
            $medic->save();
        }

        // Creacion de administrador
        $admin = new_user('admin@gmail.com', 'password');
        $admin->set_role(Role::ROLE_ADMIN);

        // Creacion de jefe de sistema
        $admin = new_user('system_chief@gmail.com', 'password');
        $admin->set_role(Role::ROLE_SYSTEM_CHIEF);

        // Creación de médico
        $medic = new_user('medic@gmail.com', 'password');
        $medic->set_role(Role::ROLE_MEDIC);
        new_medic($medic->user_id);

        // Creación de configurador de reglas
        $admin = new_user('rule_setter@gmail.com', 'password');
        $admin->set_role(Role::ROLE_RULE_SETTER);

        // Creacion de administrador
        $admin = new_user('manuelguido.m@gmail.com', 'Numera96!gG');
        $admin->set_role(Role::ROLE_ADMIN);
    }
}
