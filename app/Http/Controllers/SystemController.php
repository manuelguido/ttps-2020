<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\System;

class SystemController extends Controller
{
    /**
     * Retorna todos los sistemas
     */
    public function index()
    {
        return response()->json(System::all());
    }

    /**
     * Retorna un sistema con toda su información de camas y habitaciones
     */
    private function getFullSystem($system)
    {
        $system->total_beds = $system->totalBeds();
        $system->occupied_beds = $system->occupiedBeds();
        $system->free_beds = $system->total_beds - $system->occupied_beds;
        return $system;
    }

    /**
     * Retorna todos los sistemas con su información de camas y habitaciones
     */
    public function indexFull()
    {
        // Sistemas
        $systems = System::all();
        // Información a devolver
        $data = [];

        foreach ($systems as $s) {
            array_push($data, $this->getFullSystem($s));
        }

        return response()->json($data);
    }
}
