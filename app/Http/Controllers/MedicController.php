<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medic;
use App\Role;
use App\User;

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
     * Obtener todos los pacientes asignados al usuario médico o jefe de sistema.
     * 
     * @return JSON.
     */
    public function indexAssigned(Request $request)
    {
        $user = User::find($request->user()->user_id);        
        $data = [];
        if ($user->hasRole(Role::ROLE_SYSTEM_CHIEF))
        {
            $system_id = $user->systems()->first()->system_id;
            $data = Medic::allWithUserDataBySystem($system_id);
        }
        return response()->json($data);
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
