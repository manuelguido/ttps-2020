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
        $vm = new VentilatoryMechanic;
        $vm->ventilatory_mechanic = VentilatoryMechanic::VM_GOOD;
        $vm->save();

        $vm = new VentilatoryMechanic;
        $vm->ventilatory_mechanic = VentilatoryMechanic::VM_REGULAR;
        $vm->save();

        $vm = new VentilatoryMechanic;
        $vm->ventilatory_mechanic = VentilatoryMechanic::VM_BAD;
        $vm->save();
    }
}
