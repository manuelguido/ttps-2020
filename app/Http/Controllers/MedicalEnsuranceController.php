<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MedicalEnsurance;

class MedicalEnsuranceController extends Controller
{
    public function index()
    {
        return response()->json(MedicalEnsurance::all());
    }
}
