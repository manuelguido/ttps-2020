<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    /**
     * Show the application main view.
     *
     */
    public function index()
    {
        return view('app');
    }
}
