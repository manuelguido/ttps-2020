<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleTableSeeder::class,
            PermissionsTableSeeder::class,
            SystemTableSeeder::class,
            UsersTableSeeder::class,
            MedicalEnsuranceTableSeeder::class,
            RoomAndBedsTableSeeder::class,
            PatientStatesTableSeeder::class,
            PatientsTableSeeder::class,
        ]);
    }
}
