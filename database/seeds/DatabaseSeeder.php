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
            VentilatoryMechanicSeeder::class,
            RoleTableSeeder::class,
            PermissionsTableSeeder::class,
            SystemTableSeeder::class,
            UsersTableSeeder::class,
            MedicalEnsuranceTableSeeder::class,
            RoomAndBedsTableSeeder::class,
            PatientStatesTableSeeder::class,
            PatientsTableSeeder::class,
            FeedingTypesTableSeeder::class,
            OxigenRequirementTypesTableSeeder::class,
            RuleSettingsTableSeeder::class,
            SettingsTableSeeder::class,
        ]);
    }
}
