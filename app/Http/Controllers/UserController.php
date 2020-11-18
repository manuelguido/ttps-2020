<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;

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
            ['icon' => 'fad fa-window', 'name' => 'Sistemas', 'url' => '/dashboard/systems'],
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
            ['icon' => 'fad fa-cog', 'name' => 'Configuración', 'url' => '/dashboard/settings'],
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
            'routes' => $this->getRoutes($role),
        ];

        $data['system'] = ($request->user()->hasSystem()) ? $request->user()->systems()->first()->system : 'Sistema completo';

        return response()->json($data);
    }



    /**
     * Retora todos los médicos
     */
    public function indexMedic()
    {
        return response()->json(User::medics());
    }


     /**
     * Retora todos los médicos de un sistema
     */
    public function indexMedicBySystem($system_id)
    {
        return response()->json(User::medicsBySystem($system_id));
    }


    public function updateProfile(Request $request) {
        try {
            $user = $request->user();
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

    /**
     * Almacena un médico
     */
    public function store(Request $data)
    {
        // Rol try
        // if (! $data->user()->hasPermission(Permission::MEDIC_STORE)) {
        //     $message = ['status' => 'warning', 'message' => 'No tienes el permiso para realizar esta acción'];
        //     return response()->json($message, 200);
        // } else {
        //     if (Medic::dniExists($data->dni)) {
        //         $message = ['status' => 'warning', 'message' => 'El méidco con ese DNI ya existe en el sistema'];
        //         return response()->json($message, 200);
        //     }
        //     // Information try
        //     try {
        //         // $this->validatePatient();
        //         $medic = new User;

        //         $store_data = $data;
        //         // $store_data->system_id = System::where('system', '=', System::SYSTEM_GUARD)->first()->system_id;
                
        //         $this->save($medic, $store_data);

        //         // Returning the view
        //         $message = ['status' => 'success', 'message' => 'Paciente guardado'];
        //     } catch (\Exception $e) {
        //         $message = ['status' => 'warning', 'message' => $e->errorInfo[2]];
        //     }

        //     return response()->json($message, 200);
        // }
    }

}
