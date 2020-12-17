<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use Auth;

class RoleController extends Controller
{
    /**
     * Obtener todos los roles
     * @return JSON.
     */
    public function index()
    {
        return response()->json(Role::all());
    }

    /**
     * Obtener roles reducidos
     * @return JSON.
     */
    public function indexReduced()
    {
        return response()->json(Role::where([
            ['role', '<>', Role::ROLE_RULE_SETTER],
            ['role', '<>', Role::ROLE_SYSTEM_CHIEF],
            ])->get());
    }
}
