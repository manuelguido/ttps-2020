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

    // /**
    // * Find user using social provider's id
    // * 
    // * @param string $provider Provider name as requested from oauth e.g. facebook
    // * @param string $id User id of social provider
    // *
    // * @return User
    // */
    // public static function findForPassportSocialite($provider,$id) {
    //     $account = SocialAccount::where('provider', $provider)->where('provider_user_id', $id)->first();
    //     if($account) {
    //         if($account->user){
    //             return $account->user;
    //         }
    //     }
    //     return;
    // }

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
     * Retorna los sistemas en los que se encuentra el usuario
     */
    public function systems()
    {
        return $this->belongsToMany('App\System', 'system_user', 'user_id', 'system_id')->get();
    }

    public function set_role($role)
    {
        // Get role_id
        $role_id = Role::where('role', $role)->get()->first()->role_id;
        // Saves the role
        DB::table('role_user')->insert([
            'user_id' => $this->user_id,
            'role_id' => $role_id,
        ]);
    }

    public function has_role($role)
    {
        $roles = $this->roles();
        foreach ($roles as $r) {
            if ($r->role == $role) return True;
        }
        return False;
    }

    public function set_system($system)
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
