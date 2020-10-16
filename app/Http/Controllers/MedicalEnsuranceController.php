<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MedicalEnsurance;

class MedicalEnsuranceController extends Controller
{
    /**
     * Retorna todos los seguros médicos
     */
    public function index()
    {
        return response()->json(MedicalEnsurance::all());
    }
}
