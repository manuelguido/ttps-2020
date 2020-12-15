<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * User
     */
    const USER_INDEX = 'user_index';
    const USER_SHOW = 'user_show';
    const USER_STORE = 'user_store';
    const USER_UPDATE = 'user_update';
    const USER_DESTROY = 'user_destroy';

    /**
     * Patient
     */
    const PATIENT_INDEX = 'patient_index';
    const PATIENT_SHOW = 'patient_show';
    const PATIENT_STORE = 'patient_store';
    const PATIENT_UPDATE = 'patient_update';
    const PATIENT_DESTROY = 'patient_destroy';

    /**
     * Medic
     */
    const MEDIC_INDEX = 'medic_index';
    const MEDIC_SHOW = 'medic_show';
    const MEDIC_STORE = 'medic_store';
    const MEDIC_UPDATE = 'medic_update';
    const MEDIC_DESTROY = 'medic_destroy';

    /**
     * System
     */
    const SYSTEM_INDEX = 'system_index';
    const SYSTEM_SHOW = 'system_show';
    const SYSTEM_STORE = 'system_store';
    const SYSTEM_UPDATE = 'system_update';
    const SYSTEM_DESTROY = 'system_destroy';

    /**
     * Rules
     */
    const RULE_CRUD = 'rule_crud';

    /**
     * Rules
     */
    const ALERTS = 'alerts';


    /**
     * Attributes
     */
    protected $table = 'permissions';

    protected $primaryKey = 'permission_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission',
    ];

    public $timestamps = false;

    /**
     * Return  the users with this role
     */
    public function roles()
    {
        return $this->belongsToMany('App\User', 'permission_role', 'permission_id', 'role_id');
    }
}
