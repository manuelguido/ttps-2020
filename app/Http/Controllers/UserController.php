<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\System;
use App\Role;
use App\User;

class UserController extends Controller
{
    /**
     * Determinar las rutas del usuario y las retorna.
     * 
     * @return Array.
     */    
    private function getRoutes($user)
    {
        $role = $user->roles()->first()->role;

        switch ($role) {
            case Role::ROLE_ADMIN: return User::ADMIN_ROUTES;
            case Role::ROLE_SYSTEM_CHIEF:
                if($user->hasSystem(System::SYSTEM_GUARD)) {
                    $routes = User::SYSTEM_CHIEF_ROUTES_W_ENTRY;
                } else {
                    $routes = User::SYSTEM_CHIEF_ROUTES;
                }
                return $routes;
            case Role::ROLE_MEDIC:
                if($user->hasSystem(System::SYSTEM_GUARD)) {
                    $routes = User::MEDIC_ROUTES_W_ENTRY;
                } else {
                    $routes = User::MEDIC_ROUTES;
                }
                return $routes;
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
        $user = User::find($request->user()->user_id);
        $data = $this->getRoutes($request);
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
     * Obtener usuario loggeado con su rol, rutas(URL's) permitidas, su sistema correspondiente y sus permisos.
     * 
     * @return JSON.
     */
    public function fullUser(Request $request)
    {
        // El rol se obtiene antes para poder buscar las rutas correspondientes
        $role = $request->user()->roles()->first()->role;

        $responseData = [
            'user' => $request->user(),
            'role' => $role,
            'permissions' => $request->user()->permissions(),
            'routes' => $this->getRoutes($request->user()),
        ];

        if ($request->user()->hasRole(Role::ROLE_MEDIC) || $request->user()->hasRole(Role::ROLE_SYSTEM_CHIEF)) {
            $userSystem = $request->user()->systems()->first();
        } else {
            $userSystem = null;
        }

        $responseData['system'] = $userSystem;

        return response()->json($responseData);
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
