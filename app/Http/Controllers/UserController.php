<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class UserController extends Controller
{
    /**
     * Rutas del usuario administrador
     */
    private function adminRoutes()
    {
        return [
            ['icon' => 'fad fa-tachometer-fast', 'name' => 'Inicio', 'url' => '/dashboard/home'],
            ['icon' => 'fad fa-user-nurse', 'name' => 'Médicos', 'url' => '/dashboard/medics'],
            ['icon' => 'fad fa-user-alt', 'name' => 'Pacientes', 'url' => '/dashboard/patients'],
        ];
    }

    /**
     * Rutas del usuario jefe de sistema
     */
    private function systemChiefRoutes()
    {
        return [
            ['icon' => 'fad fa-tachometer-fast', 'name' => 'Inicio', 'url' => '/dashboard/home'],
            ['icon' => 'fad fa-user-nurse', 'name' => 'Médicos', 'url' => '/dashboard/medics'],
            ['icon' => 'fad fa-user-alt', 'name' => 'Pacientes', 'url' => '/dashboard/patients'],
        ];
    }

    /**
     * Rutas del usuario médico
     */
    private function medicRoutes()
    {
        return [
            ['icon' => 'fad fa-tachometer-fast', 'name' => 'Inicio', 'url' => '/dashboard/home'],
            ['icon' => 'fad fa-user-alt', 'name' => 'Pacientes', 'url' => '/dashboard/patients'],
        ];
    }

    /**
     * Rutas del usuario configurador de reglas
     */
    private function ruleSetterRoutes()
    {
        return [
            ['icon' => 'fad fa-tachometer-fast', 'name' => 'Inicio', 'url' => '/dashboard/home'],
        ];
    }

    /**
     * Determina las rutas del usuario y las retorna
     */    
    private function getRoutes($role)
    {
        // Es ADMIN
        if ($role == ROLE::ROLE_ADMIN)
        {
            return $this->adminRoutes();
        }
        // Es JEFE DE SISTEMA
        else if ($role == ROLE::ROLE_SYSTEM_CHIEF)
        {
            return $this->medicRoutes();
        }
        // Es MEDICO
        else if ($role == ROLE::ROLE_MEDIC)
        {
            return $this->medicRoutes();
        }
        // Es CONFIGURADOR DE REGLAS
        else if ($role == ROLE::ROLE_RULE_SETTER)
        {
            return $this->ruleSetterRoutes();
        }
        // No es nada
        else 
        {
            return [''];
        }

        // return $this->adminRoutes();
    }

    /**
     * Retorna las rutas del usuario en modo JSON para la la API
     */
    public function routes(Request $request)
    {
        $role = $request->user()->roles()->first()->role;
        $data = $this->getRoutes($role);
        return response()->json($data);
    }

    /**
     * Retorna el usuario
     */
    public function user(Request $request)
    {
        return $request->user();
    }

    /**
     * Retorna el rol del usuario
     */
    public function role(Request $request)
    {
        return $request->user()->roles()->first()->role;
    }

    /**
     * Retorna el systema del usuario
     */
    public function system(Request $request)
    {
        return $request->user()->systems()->first()->role;
    }
}
