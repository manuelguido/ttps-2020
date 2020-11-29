<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medic extends Model
{
    /**
     * Attributes
     */
    protected $table = 'medics';

    protected $primaryKey = 'medic_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    public $timestamps = false;

    /**
     * Obtener el usuario del médico.
     * 
     * @return App\User.
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }

    /**
     * Obtener los pacientes asignados del médico.
     * 
     * @return App\Patient.
     */
    public function patients()
    {
        return $this->belongsToMany('App\Patient', 'patient_medic', 'medic_id', 'patient_id');
    }


    /**
     * Obtiene todos los médicos.
     * 
     */
    public static function allWithUserData()
    {
        return Medic::join('users', 'users.user_id', '=', 'medics.user_id')
            ->leftJoin('system_user', 'system_user.user_id', '=', 'users.user_id')
            ->leftJoin('systems', 'systems.system_id', '=', 'system_user.system_id')
            ->get();
    }

    /**
     * Obtiene todos los médicos de un sistema
     */
    public static function allWithUserDataBySystem($system_id)
    {
        return Medic::where('systems.system_id', '=', $system_id)
            ->join('users', 'users.user_id', '=', 'medics.user_id')
            ->leftJoin('system_user', 'system_user.user_id', '=', 'users.user_id')
            ->leftJoin('systems', 'systems.system_id', '=', 'system_user.system_id')
            ->get();
    }
}
