<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Crea un permiso
         */
        function create_permission($name)
        {
            $permission = new Permission;
            $permission->permission = $name;
            $permission->save();
        }

        function add_permission($role, $permission)
        {
            Role::where('role', '=', $role)->first()->addPermissionById(
                Permission::where('permission', '=', $permission)->first()->permission_id
            );
        }

        /**
         * User
         */
        create_permission(Permission::USER_INDEX);
        create_permission(Permission::USER_SHOW);
        create_permission(Permission::USER_STORE);
        create_permission(Permission::USER_UPDATE);
        create_permission(Permission::USER_DESTROY);

        /**
         * Patient
         */
        create_permission(Permission::PATIENT_INDEX);
        create_permission(Permission::PATIENT_SHOW);
        create_permission(Permission::PATIENT_STORE);
        create_permission(Permission::PATIENT_UPDATE);
        create_permission(Permission::PATIENT_DESTROY);

        /**
         * Medic
         */
        create_permission(Permission::MEDIC_INDEX);
        create_permission(Permission::MEDIC_SHOW);
        create_permission(Permission::MEDIC_STORE);
        create_permission(Permission::MEDIC_UPDATE);
        create_permission(Permission::MEDIC_DESTROY);

        /**
         * System
         */
        create_permission(Permission::SYSTEM_INDEX);
        create_permission(Permission::SYSTEM_SHOW);
        create_permission(Permission::SYSTEM_STORE);
        create_permission(Permission::SYSTEM_UPDATE);
        create_permission(Permission::SYSTEM_DESTROY);

        /**
         * Rule
         */
        create_permission(Permission::RULE_CRUD);

        /**
         * Añadir a permisos ADMINISTRADOR
         */
        add_permission(Role::ROLE_ADMIN, Permission::USER_INDEX);
        add_permission(Role::ROLE_ADMIN, Permission::USER_SHOW);
        add_permission(Role::ROLE_ADMIN, Permission::USER_STORE);
        add_permission(Role::ROLE_ADMIN, Permission::USER_UPDATE);
        add_permission(Role::ROLE_ADMIN, Permission::USER_DESTROY);

        add_permission(Role::ROLE_ADMIN, Permission::MEDIC_INDEX);
        add_permission(Role::ROLE_ADMIN, Permission::MEDIC_SHOW);
        add_permission(Role::ROLE_ADMIN, Permission::MEDIC_STORE);
        add_permission(Role::ROLE_ADMIN, Permission::MEDIC_UPDATE);
        add_permission(Role::ROLE_ADMIN, Permission::MEDIC_DESTROY);

        add_permission(Role::ROLE_ADMIN, Permission::SYSTEM_INDEX);
        add_permission(Role::ROLE_ADMIN, Permission::SYSTEM_SHOW);
        add_permission(Role::ROLE_ADMIN, Permission::SYSTEM_STORE);
        add_permission(Role::ROLE_ADMIN, Permission::SYSTEM_UPDATE);
        add_permission(Role::ROLE_ADMIN, Permission::SYSTEM_DESTROY);

        /**
         * Añadir a permisos JEFE DE SISTEMA
         */
        add_permission(Role::ROLE_SYSTEM_CHIEF, Permission::PATIENT_INDEX);
        add_permission(Role::ROLE_SYSTEM_CHIEF, Permission::PATIENT_SHOW);
        add_permission(Role::ROLE_SYSTEM_CHIEF, Permission::PATIENT_STORE);
        add_permission(Role::ROLE_SYSTEM_CHIEF, Permission::PATIENT_UPDATE);
        add_permission(Role::ROLE_SYSTEM_CHIEF, Permission::PATIENT_DESTROY);
        
        add_permission(Role::ROLE_SYSTEM_CHIEF, Permission::MEDIC_INDEX);
        add_permission(Role::ROLE_SYSTEM_CHIEF, Permission::MEDIC_SHOW);
        add_permission(Role::ROLE_SYSTEM_CHIEF, Permission::MEDIC_STORE);
        add_permission(Role::ROLE_SYSTEM_CHIEF, Permission::MEDIC_UPDATE);
        add_permission(Role::ROLE_SYSTEM_CHIEF, Permission::MEDIC_DESTROY);

        add_permission(Role::ROLE_SYSTEM_CHIEF, Permission::SYSTEM_INDEX);
        add_permission(Role::ROLE_SYSTEM_CHIEF, Permission::SYSTEM_SHOW);

        /**
         * Añadir a permisos MEDICOS
         */
        add_permission(Role::ROLE_MEDIC, Permission::PATIENT_INDEX);
        add_permission(Role::ROLE_MEDIC, Permission::PATIENT_SHOW);
        add_permission(Role::ROLE_MEDIC, Permission::PATIENT_STORE);
        add_permission(Role::ROLE_MEDIC, Permission::PATIENT_UPDATE);
        add_permission(Role::ROLE_MEDIC, Permission::PATIENT_DESTROY);

        /**
         * Añadir a permisos CONFIGURADOR DE REGLAS
         */
        add_permission(Role::ROLE_RULE_SETTER, Permission::RULE_CRUD);
        add_permission(Role::ROLE_RULE_SETTER, Permission::SYSTEM_INDEX);
        add_permission(Role::ROLE_RULE_SETTER, Permission::SYSTEM_SHOW);
    }
}
