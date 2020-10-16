<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PatientState;

class PatientStateController extends Controller
{
    /**
     * Retorna todos los estados de paciente
     */
    public function index()
    {
        return response()->json(PatientState::all());
    }
}
