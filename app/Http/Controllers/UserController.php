<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;

class UserController extends Controller
{
    /**
     * Rutas del usuario administrador
     * 
     * @return Array.
     */
    private function adminRoutes()
    {
        return [
            ['icon' => 'fad fa-tachometer-fast', 'name' => 'Inicio', 'url' => '/dashboard/home'],
            ['icon' => 'fad fa-user-nurse', 'name' => 'Médicos', 'url' => '/dashboard/medics'],
            ['icon' => 'fad fa-user-alt', 'name' => 'Pacientes', 'url' => '/dashboard/patients'],
            ['icon' => 'fad fa-window', 'name' => 'Sistemas', 'url' => '/dashboard/systems'],
        ];
    }

    /**
     * Rutas del usuario jefe de sistema
     * 
     * @return Array.
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
     * 
     * @return Array.
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
     * 
     * @return Array.
     */
    private function ruleSetterRoutes()
    {
        return [
            ['icon' => 'fad fa-tachometer-fast', 'name' => 'Inicio', 'url' => '/dashboard/home'],
            ['icon' => 'fad fa-cog', 'name' => 'Configuración', 'url' => '/dashboard/settings'],
        ];
    }

    /**
     * Determinar las rutas del usuario y las retorna.
     * 
     * @return Array.
     */    
    private function getRoutes($role)
    {
        switch ($role) {
            case Role::ROLE_ADMIN: return User::ADMIN_ROUTES;
            case Role::ROLE_SYSTEM_CHIEF: return User::SYSTEM_CHIEF_ROUTES;
            case Role::ROLE_MEDIC: return User::MEDIC_ROUTES;
            case Role::ROLE_RULE_SETTER: return User::RULE_SETTER_ROUTES;
            default: return [''];
        }
    }

    /**
     * Obtener las rutas del usuario.
     * 
     * @return JSON.
     */
    public function routes(Request $request)
    {
        $role = $request->user()->roles()->first()->role;
        $data = $this->getRoutes($role);
        return response()->json($data);
    }

    /**
     * Retorna el usuario
     * 
     * @return JSON.
     */
    public function user(Request $request)
    {
        return $request->user();
    }

    /**
     * Retorna el rol del usuario
     * 
     * @return JSON.
     */
    public function role(Request $request)
    {
        return $request->user()->roles()->first()->role;
    }

    /**
     * Retorna el sistema del usuario
     * 
     * @return JSON.
     */
    public function system(Request $request)
    {
        return $request->user()->systems()->first()->system;
    }


    /**
     * Obtener usuario loggeado con su rol, rutas(URL's) permitidas, su sistema correspondiente y sus permisos
     * 
     * @return JSON.
     */
    public function fullUser(Request $request)
    {
        // El rol se obtiene antes para poder buscar las rutas correspondientes
        $role = $request->user()->roles()->first()->role;

        $data = [
            'user' => $request->user(),
            'role' => $role,
            'permissions' => $request->user()->permissions(),
            'routes' => $this->getRoutes($role),
        ];

        $data['system'] = ($request->user()->hasSystem()) ? $request->user()->systems()->first()->system : 'Sistema completo';

        return response()->json($data);
    }

    /**
     * Actualizar perfil de usuario
     * 
     * @return JSON.
     */
    public function updateProfile(Request $request) {
        try {
            // Obtener usuario
            $user = $request->user();

            // Chequear que el email no exista en el sistema
            $newEmail = $request['email'];
            $newEmailExists = User::getByEmail($request['email']);
            if ($user->email != $newEmail && $newEmailExists) {
                $message = ['status' => 'warning', 'message' => 'El email ya existe en el sistema.'];
                return response()->json($message, 200);
            }
            
            // Actualizar usuario
            $user->name = $request['name'];
            $user->lastname = $request['lastname'];
            $user->email = $request['email'];
            $user->dni = $request['dni'];
            $user->phone = $request['phone'];
            $user->save();

            $message = ['status' => 'success', 'message' => 'Actualizaste tu perfil', 'user' => $user];
        } catch (\Exception $e) {
            $message = ['status' => 'warning', 'message' => 'Ocurrió un error, vuelve a intentarlo más tarde'];
        }

        return response()->json($message, 200);
    }
}
