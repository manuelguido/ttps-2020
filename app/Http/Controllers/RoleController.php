<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use Auth;

class RoleController extends Controller
{
    public function has_role($role)
    {
        return Auth::user()->has_role($role);
    }
}
