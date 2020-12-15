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
        return Patient::where([
            ['medics.medic_id', '=', $this->medic_id],
            ['patient_states.patient_state', '=', PatientState::STATE_HOSPITALIZED],
            ])
            ->join('patient_medic', 'patient_medic.patient_id', '=', 'patients.patient_id')
            ->join('medics', 'medics.medic_id', '=', 'patient_medic.medic_id')
            ->join('systems', 'systems.system_id', '=', 'patients.system_id')
            ->join('patient_states', 'patient_states.patient_state_id', '=', 'patients.patient_state_id')
            ->leftJoin('beds', 'beds.patient_id', '=', 'patients.patient_id')
            ->leftJoin('rooms', 'rooms.room_id', '=', 'beds.room_id')
            ->select('patients.*', 'systems.system', 'rooms.room', 'beds.number AS bed_number')
            ->orderBy('updated_at', 'DESC'); 
        // return $this->belongsToMany('App\Patient', 'patient_medic', 'medic_id', 'patient_id');
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
            ->select('medic_id', 'name', 'lastname', 'dni', 'email', 'phone')
            ->get();
    }
}
