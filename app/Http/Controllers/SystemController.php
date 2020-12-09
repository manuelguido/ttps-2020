<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\System;

class SystemController extends Controller
{
    /**
     * Validación de id de sistema
     * 
     * @return Boolean.
     */
    private function validateId()
    {
        return request()->validate([
            'system_id' => 'required|integer|min:1',
        ]);
    }

    /**
     * Obtener todos los sistemas
     * 
     * @return JSON.
     */
    public function index()
    {
        return response()->json(System::all());
    }

    /**
     * Obtener un sistema con toda su información de camas y habitaciones
     * 
     * @return JSON.
     */
    private function getFullSystem($system)
    {
        $system->total_rooms = $system->totalRooms();
        $system->total_beds = $system->totalBeds();
        $system->occupied_beds = $system->occupiedBeds();
        $system->free_beds = $system->total_beds - $system->occupied_beds;
        return $system;
    }

    /**
     * Obtener todos los sistemas con su información de camas y habitaciones.
     * 
     * @return JSON.
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

    /**
     * Obtener un sistema con su información de camas y habitaciones.
     * 
     * @return JSON.
     */
    public function showFull(Request $data)
    {
        // Validación
        $this->validateId();
        // Sistemas
        $system = System::find($data->system_id);
        // Información a devolver

        return response()->json($this->getFullSystem($system));
    }

    /**
     * Retorna un sistema con su información de camas y habitaciones.
     * 
     * @return JSON.
     */
    public function allowedIndex(Request $data)
    {
        // Validación
        $this->validateId();
        // Sistemas
        $system = System::find($data->system_id);

        return response()->json($system->allowedSystemsToChange());
    }
}
