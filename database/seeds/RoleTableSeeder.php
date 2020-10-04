<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        function create_role($name)
        {
            $role = new Role;
            $role->role = $name;
            $role->save();
        }

        create_role(Role::ROLE_ADMIN);
        create_role(Role::ROLE_SYSTEM_CHIEF);
        create_role(Role::ROLE_MEDIC);
        create_role(Role::ROLE_RULE_SETTER);
    }
}
