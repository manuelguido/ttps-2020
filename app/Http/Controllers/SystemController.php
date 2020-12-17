<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\System;

class SystemController extends Controller
{
    /**
     * Validación de id de sistema.
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
     * Validación de id de sistema.
     * 
     * @return Boolean.
     */
    private function validateInfiniteBeds()
    {
        return request()->validate([
            'infinite_beds' => 'required|boolean',
        ]);
    }

    /**
     * Obtener todos los sistemas con su información de camas y habitaciones.
     * 
     * @return JSON.
     */
    public function index()
    {
        $responseData = [];
        foreach (System::all() as $s) {
            array_push($responseData, $this->getFullSystem($s));
        }

        return response()->json($responseData);
    }


    /**
     * Obtener todos los sistemas.
     * 
     * @return JSON.
     */
    public function indexReduced()
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
     * Obtener un sistema con su información de camas y habitaciones.
     * 
     * @return JSON.
     */
    public function show(Request $data)
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

        $actual_system = System::find($data->system_id); // Sistema actual.
        $systems = $actual_system->allowedSystemsToChange(); // Sistemas disponibles y permitidos a pasar.

        foreach ($systems as $system) {
            $system = $this->getFullSystem($system);
        }

        return response()->json($systems);
    }

    /**
     * Actualizar la disponibilidad de camas infinitas en guardia.
     * 
     * @return JSON.
     */
    public function updateInfiniteBedsOnGuard(Request $data)
    {
        // try {
            // Validación
            $this->validateInfiniteBeds();

            $guard = System::where('system', '=', System::SYSTEM_GUARD)->first();

            if (!$guard->ableToUpdateInfiniteBeds()) {
                $message = ['status' => 'warning', 'message' => 'Necesitas desocupar camas para volver a la configuración de camas limitadas.'];
            } else {
                $guard->updateInfiniteBeds($data->infinite_beds);
                $message = ['status' => 'success', 'message' => 'Guardaste la información.'];
            }
            
            $message = ['status' => 'success', 'message' => 'Guardaste la información.'];
        // } catch (\Exception $e) {
            // $message = ['status' => 'danger', 'message' => 'Ingresaste información no válida.'];
        // }

        return response()->json($message);
    }
}
