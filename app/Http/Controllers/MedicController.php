<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medic;

class MedicController extends Controller
{
    /**
     * Obtener todos los médicos
     * 
     * @return JSON.
     */
    public function index()
    {
        return response()->json(Medic::allWithUserData());
    }

    /**
     * Obtener todos los médicos de un sistema por su ID
     * 
     * @return JSON.
     */
    public function indexBySystem($system_id)
    {
        return response()->json(Medic::allWithUserDataBySystem($system_id));
    }

    /**
     * Almacena un médico
     */
    public function store(Request $data)
    {

    }
}
