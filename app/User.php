<?php

namespace App;

use DB;
use App\System;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * User routes.
     */
    const ADMIN_ROUTES = [
        ['icon' => 'fad fa-analytics', 'name' => 'Reportes', 'url' => '/dashboard/reports'],
        ['icon' => 'fad fa-window', 'name' => 'Sistemas', 'url' => '/dashboard/systems'],
        ['icon' => 'fad fa-users', 'name' => 'Usuarios', 'url' => '/dashboard/users'],
    ];

    const SYSTEM_CHIEF_ROUTES = [
        ['icon' => 'fad fa-user-tag', 'name' => 'Pacientes', 'url' => '/dashboard/patients'],
        ['icon' => 'fad fa-user-nurse', 'name' => 'Médicos', 'url' => '/dashboard/medics'],
        ['icon' => 'fad fa-window', 'name' => 'Sistemas', 'url' => '/dashboard/systems'],
    ];

    const SYSTEM_CHIEF_ROUTES_W_ENTRY = [
        ['icon' => 'fad fa-user-tag', 'name' => 'Pacientes', 'url' => '/dashboard/patients'],
        ['icon' => 'fad fa-user-nurse', 'name' => 'Médicos', 'url' => '/dashboard/medics'],
        ['icon' => 'fad fa-user-plus', 'name' => 'Nueva internación', 'url' => '/dashboard/new_entry'],
        ['icon' => 'fad fa-window', 'name' => 'Sistemas', 'url' => '/dashboard/systems'],
    ];

    const MEDIC_ROUTES = [
        ['icon' => 'fad fa-user-alt', 'name' => 'Pacientes', 'url' => '/dashboard/patients'],
    ];

    const MEDIC_ROUTES_W_ENTRY = [
        ['icon' => 'fad fa-user-alt', 'name' => 'Pacientes', 'url' => '/dashboard/patients'],
        ['icon' => 'fad fa-user-plus', 'name' => 'Nueva internación', 'url' => '/dashboard/new_entry'],
    ];

    const RULE_SETTER_ROUTES = [
        ['icon' => 'fad fa-cog', 'name' => 'Configuración', 'url' => '/dashboard/rules_settings'],
    ];


    /**
     * Attributes
     */
    protected $table = 'users';

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'phone', 'dni', 'image',
    ];

    public $timestamps = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Crear un nuevo usuario.
     * 
     * @return App\User.
     */
    public static function create($data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->dni = $data['dni'];
        $user->password = bcrypt($data['password']);
        $user->save();
        return $user;
    }

    /**
     * Obtener todos los usuarios con su rol y systema.
     * 
     * @return Collection.
     */
    public static function allComplete()
    {
        return User::join('role_user', 'role_user.user_id', '=', 'users.user_id')
            ->join('roles', 'roles.role_id', '=', 'role_user.role_id')
            ->leftJoin('system_user', 'system_user.user_id', '=', 'users.user_id')
            ->leftJoin('systems', 'systems.system_id', '=', 'system_user.system_id')
            ->select('users.*', 'systems.system', 'roles.role');
    }

    /**
     * Retorna el usuario correspondiente al médico
     * 
     * @return App\Medic.
     */
    public function medic()
    {
        return Medic::where('user_id', $this->user_id)->first();
    }
    
    /**
     * Retorna los roles del usuario
     * 
     * @return App\Role.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }


    /**
     * Retorna los permisos del usuario
     * 
     * @return App\Permission.
     */
    public function permissions()
    {
        return Permission::where('role_user.user_id', '=', $this->user_id)
            ->join('permission_role', 'permission_role.permission_id', '=', 'permissions.permission_id')
            ->join('roles', 'roles.role_id', '=', 'permission_role.role_id')
            ->join('role_user', 'role_user.role_id', '=', 'roles.role_id')
            ->select('permissions.*')
            ->get();
    }

    /**
     * Retorna los sistemas en los que se encuentra el usuario
     * 
     * @return App\System.
     */
    public function systems()
    {
        return $this->belongsToMany('App\System', 'system_user', 'user_id', 'system_id');
    } 


    /**
     * Obtener todas las alertas del usuario.
     * 
     * @return App\Alert Collection.
     */
    public function alerts()
    {
        return Alert::where('user_id', $this->user_id)->orderBy('created_at', 'DESC');
    }

    /**
     * Obtener todas las alertas del usuario con información adicional.
     * 
     * @return Collection.
     */
    public function alertsFull()
    {
        return Alert::where('user_id', $this->user_id)->orderBy('created_at', 'DESC')
            ->join('patients', 'patients.patient_id', '=', 'alerts.patient_id')
            ->select('alerts.*', 'patients.name', 'patients.lastname', 'patients.dni');
    }

    /**
     * Obtener todas las alertas del usuario con información adicional.
     * 
     * @return Collection.
     */
    public function alertsBySeen($value)
    {
        return Alert::where([
                ['user_id', $this->user_id],
                ['seen', $value],
            ])
            ->join('patients', 'patients.patient_id', '=', 'alerts.patient_id')
            ->orderBy('created_at', 'DESC')
            ->select('alerts.*', 'patients.name', 'patients.lastname', 'patients.dni');
    }

    /**
     * Obtener el usuario si ya existe, sino retornar falso.
     * 
     * @return App\User. Boolean.
     */
    public static function getByEmail($email)
    {
        $user = User::where('email', '=', $email)->get();
        $userExists = (count($user) == 0); 
        return $userExists ? false : $user->first();
    }

    /**
     * Agregar un nuevo rol a un usuario.
     * 
     * @return void.
     */
    public function setRole($roleName)
    {
        // Obtener objeto rol por su nombre
        $role = Role::where('role', $roleName)->get()->first();
        // Crear la relación en role_user
        DB::table('role_user')->insert([
            'user_id' => $this->user_id,
            'role_id' => $role->role_id,
        ]);

        if ($roleName == Role::ROLE_MEDIC)
        {
            $medic = new Medic;
            $medic->user_id = $this->user_id;
            $medic->save();
        }
    }

    /**
     * Chequear si el usuario tien permiso.
     * 
     */
    public function hasPermission($permission)
    {
        $result = Permission::where([
            ['permissions.permission', '=', $permission],
            ['role_user.user_id', '=', $this->user_id]
            ])
            ->join('permission_role', 'permission_role.permission_id', '=', 'permissions.permission_id')
            ->join('roles', 'roles.role_id', '=', 'permission_role.role_id')
            ->join('role_user', 'role_user.role_id', '=', 'roles.role_id')
            ->count();
        
        return ($result > 0);
    }

    /**
     * Chequear si el usuario tiene rol.
     * 
     * @return Boolean.
     */
    public function hasRole($role)
    {
        $result = Role::where([
                ['roles.role', '=', $role],
                ['role_user.user_id', '=', $this->user_id],
            ])
            ->join('role_user', 'role_user.role_id', '=', 'roles.role_id')
            ->count();
        return ($result > 0);
    }

    /**
     * Chequea si el usuario esta asginado a un sistema:
     * 
     * @return Boolean.
     */
    public function hasSystem($system)
    {
        $result = System::where([
            ['system_user.user_id', '=', $this->user_id],
            ['systems.system', '=', $system],
            ])
            ->join('system_user', 'system_user.system_id', '=', 'systems.system_id')
            ->count();
        return ($result > 0);
    }


    /**
     * Agregar un usuario a un sistema
     * 
     */
    public function setSystem($system)
    {
        // Get system_id
        $system_id = System::where('system', $system)->get()->first()->system_id;
        // Saves the system
        DB::table('system_user')->insert([
            'user_id' => $this->user_id,
            'system_id' => $system_id,
        ]);
    }

    /**
     * Corroborar que un usuario pueda dar de alta un paciente.
     * 
     * @return Boolean.
     */
    public function canEditPatient($patient)
    {
        if ($this->hasRole(Role::ROLE_SYSTEM_CHIEF)) {
            return ($this->systems()->first()->system_id == $patient->system_id);
        } else if ($this->hasRole(Role::ROLE_MEDIC)) {
            return $this->medic()->hasPatient($patient);
        } else {
            return false;
        }
    }
}
