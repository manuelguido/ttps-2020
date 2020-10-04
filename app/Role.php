<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ROLE_ADMIN = 'Administrador';
    const ROLE_SYSTEM_CHIEF = 'Jefe de Sistema';
    const ROLE_MEDIC = 'Médico';
    const ROLE_RULE_SETTER = 'Configurador de Reglas';

    /**
     * Attributes
     */
    protected $table = 'roles';

    protected $primaryKey = 'role_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role',
    ];

    public $timestamps = false;


    /**
     * Return  the users with this role
     */
    public function users()
    {
        return $this->belongsToMany('App\User','role_user', 'role_id', 'user_id');
    }
}
