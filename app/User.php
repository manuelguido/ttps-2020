<?php

namespace App;

use DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
// Social login
// use Schedula\Laravel\PassportSocialite\User\UserSocialAccount;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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
        'name', 'lastname', 'email', 'phone', 'dni', 'password', 'image',
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

    public static function getByEmail($email)
    {
        $user = User::where('email', '=', $email)->get();
        
        if (count($user) == 0) {
            return false;
        } else {
            return $user->first();
        }
    }

    /**
     * Retorna el usuario correspondiente al médico
     */
    public function medic()
    {
        return $this->belongsTo('App\Medic', 'user_id', 'user_id')->get();
    }
    
    /**
     * Retorna los roles del usuario
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id')->get();
    }


    /**
     * Retorna los permisos del usuario
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
     */
    public function systems()
    {
        return $this->belongsToMany('App\System', 'system_user', 'user_id', 'system_id')->get();
    } 


    /**
     * Retorna los sistemas en los que se encuentra el usuario
     */
    public function bed()
    {
        return $this->belongsTo('App\Bed');
    }

    public function setRole($role)
    {
        // Get role_id
        $role_id = Role::where('role', $role)->get()->first()->role_id;
        // Saves the role
        DB::table('role_user')->insert([
            'user_id' => $this->user_id,
            'role_id' => $role_id,
        ]);
    }

    /**
     * Chequear si el usuario tiene rol
     */
    public function hasRole($role)
    {
        $result = Role::where([
            ['roles.role', '=', $role],
            ['role_user.user_id', '=', $this->id]
            ])
            ->join('role_user', 'role_user.role_id', '=', 'roles.role_id')
            ->count();
        
        return ($result > 0);
    }

    /**
     * Chequear si el usuario tien permiso
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
}
