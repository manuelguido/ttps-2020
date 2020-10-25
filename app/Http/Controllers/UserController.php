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
            ['icon' => 'fad fa-window', 'name' => 'Sistemas', 'url' => '/dashboard/systems'],
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
        switch ($role) {
            case ROLE::ROLE_ADMIN: return $this->adminRoutes();
            case ROLE::ROLE_SYSTEM_CHIEF: return $this->systemChiefRoutes();
            case ROLE::ROLE_MEDIC: return $this->medicRoutes();
            case ROLE::ROLE_RULE_SETTER: return $this->ruleSetterRoutes();
            default: return [''];
        }
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
     * Retorna el sistema del usuario
     */
    public function system(Request $request)
    {
        return $request->user()->systems()->first()->system;
    }


    /**
     * Retorna el usuario con el rol, sus rutas(de url) y su sistema correspondiente y sus permisos
     */
    public function fullUser(Request $request)
    {
        // El rol se obtiene antes para poder buscar las rutas correspondientes
        $role = $request->user()->roles()->first()->role;

        $data = [
            'user' => $request->user(),
            'role' => $role,
            'permissions' => $request->user()->permissions(),
            'system' => $request->user()->systems()->first()->system,
            'routes' => $this->getRoutes($role),
        ];
        return response()->json($data);
    }
}
