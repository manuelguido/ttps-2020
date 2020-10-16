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
}
