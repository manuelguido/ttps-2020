<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\System;
use App\Role;
use App\User;

class UserController extends Controller
{
    /**
     * Validación de información de parametros.
     * 
     * @return void.
     */
    private function validateUser($data)
    {
        $this->validate($data, [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'password' => 'required|string',
            'phone' => 'required|integer|min:1',
            'dni' => 'required|integer|min:1|max:999999999',
            'email' => 'required|string',
            'role_id' => 'sometimes|integer|min:1',
            'system_id' => 'sometimes|integer|min:1',
        ]);
    }

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
     * Almacenar un usuario.
     * 
     * @return JSON.
     */
    public function store(Request $data)
    {
        // Information try
        try {
            // Validación de paciente
            $this->validateUser($data);
            // Chequeo de DNI existente
            if (User::getByEmail($data->email)) {
                $message = ['status' => 'warning', 'message' => 'El email ingresado ya existe en el sistema.'];
            }
            else {
                // Nuevo usuario
                $user = User::create($data);
                $role = Role::find($data->role_id);
                $user->setRole($role->role);
                if (($role->role == Role::ROLE_MEDIC || $role->role == Role::ROLE_SYSTEM_CHIEF) && ($data->system_id)) {
                    $user->setSystemById($data->system_id);
                }
                // Mensaje
                $message = ['status' => 'success', 'message' => 'Se guardo el paciente y ha sido ingresado a guardia.'];
            }
        } catch (\Exception $e) {
            $message = ['status' => 'warning', 'message' => 'Ocurrió un error. Verifica la información ingresada.'];
        }    
        return response()->json($message, 200);
    }

    /**
     * Retorna el usuario.
     * 
     * @return JSON.
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Retorna el usuario.
     * 
     * @return JSON.
     */
    public function index()
    {
        return response()->json(User::allComplete()->get());
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
     * Retorna el rol del usuario.
     * 
     * @return JSON.
     */
    public function role(Request $request)
    {
        return response()->json($request->user()->roles()->first()->role);
    }

    /**
     * Retorna el sistema del usuario.
     * 
     * @return JSON.
     */
    public function system(Request $request)
    {
        return response()->json($request->user()->systems()->first()->system);
    }

    /**
     * Obtener usuario loggeado con su rol, rutas(URL's) permitidas, su sistema correspondiente y sus permisos.
     * 
     * @return JSON.
     */
    public function userData(Request $request)
    {
        $user = $request->user();
        $role = $user->roles()->first()->role;

        $responseData = [
            'user' => $user,
            'role' => $role,
            'permissions' => $user->permissions(),
            'routes' => $this->getRoutes($user),
            'system' => null,
        ];

        if ($user->hasRole(Role::ROLE_MEDIC) || $user->hasRole(Role::ROLE_SYSTEM_CHIEF)) {
            $responseData['system'] = $user->systems()->first();
        }

        return response()->json($responseData);
    }

    /**
     * Actualizar perfil de usuario.
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
