<?php

use Illuminate\Database\Seeder;
use App\VentilatoryMechanic;

class VentilatoryMechanicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VentilatoryMechanic::createVentilatoryMechanic(VentilatoryMechanic::GOOD);
        VentilatoryMechanic::createVentilatoryMechanic(VentilatoryMechanic::REGULAR);
        VentilatoryMechanic::createVentilatoryMechanic(VentilatoryMechanic::BAD);
    }
}
