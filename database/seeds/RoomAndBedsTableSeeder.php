<?php

use Illuminate\Database\Seeder;
use App\System;
use App\Room;
use App\Bed;

class RoomAndBedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Creo sala
         */
        function createRoom($name, $system_id)
        {
            $room = new Room;
            $room->room = $name;
            $room->system_id = $system_id;
            $room->save();
            return $room;
        }
        /**
         * Creo cama
         */
        function createBed($number, $room_id)
        {
            $bed = new Bed;
            $bed->number = $number;
            $bed->room_id = $room_id;
            $bed->save();
            return $bed;
        }

        /**
         * Salas del sistema de guardia
         */
        // Guardo el id
        $system_id = $system_id = System::where('system', System::SYSTEM_GUARD)->get()->first()->system_id;
        // Creo la sala
        $room = createRoom('Sala 1', $system_id);
        // Creo las camas
        for ($i=1; $i <= 15; $i++) { 
            createBed($i, $room->room_id);
        }
        // Creo sala
        $room = createRoom('Sala 2', $system_id);
        // Creo las camas
        for ($i=1; $i <= 20; $i++) { 
            createBed($i, $room->room_id);
        }

        /**
         * Salas del sistema de piso covid
         */
        // Guardo el id
        $system_id = $system_id = System::where('system', System::SYSTEM_COVID_FLOOR)->get()->first()->system_id;
        // Creo la sala
        $room = createRoom('Sala 1', $system_id);
        // Creo las camas
        for ($i=1; $i <= 25; $i++) { 
            createBed($i, $room->room_id);
        }
        // Creo sala
        $room = createRoom('Sala 2', $system_id);
        // Creo las camas
        for ($i=1; $i <= 20; $i++) { 
            createBed($i, $room->room_id);
        }

        /**
         * Salas del sistema de uti
         */
        // Guardo el id
        $system_id = $system_id = System::where('system', System::SYSTEM_UTI)->get()->first()->system_id;
        // Creo la sala
        $room = createRoom('Sala 1', $system_id);
        // Creo las camas
        for ($i=1; $i <= 12; $i++) { 
            createBed($i, $room->room_id);
        }
        // Creo sala
        $room = createRoom('Sala 2', $system_id);
        // Creo las camas
        for ($i=1; $i <= 10; $i++) { 
            createBed($i, $room->room_id);
        }

        /**
         * Salas del sistema de hotel
         */
        // Guardo el id
        $system_id = $system_id = System::where('system', System::SYSTEM_HOTEL)->get()->first()->system_id;
        // Creo la sala
        $room = createRoom('Sala 1', $system_id);
        // Creo las camas
        for ($i=1; $i <= 35; $i++) { 
            createBed($i, $room->room_id);
        }
        // Creo sala
        $room = createRoom('Sala 2', $system_id);
        // Creo las camas
        for ($i=1; $i <= 20; $i++) { 
            createBed($i, $room->room_id);
        }
        // Creo sala
        $room = createRoom('Sala 3', $system_id);
        // Creo las camas
        for ($i=1; $i <= 30; $i++) { 
            createBed($i, $room->room_id);
        }

        /**
         * Salas del sistema de domicilio
         */
        // Guardo el id
        $system_id = $system_id = System::where('system', System::SYSTEM_HOME)->get()->first()->system_id;
        // Creo la sala
        $room = createRoom('Sala 1', $system_id);
        // Creo las camas
        for ($i=1; $i <= 12; $i++) { 
            createBed($i, $room->room_id);
        }
        // Creo sala
        $room = createRoom('Sala 2', $system_id);
        // Creo las camas
        for ($i=1; $i <= 20; $i++) { 
            createBed($i, $room->room_id);
        }
    }
}
