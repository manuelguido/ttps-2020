<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Patient extends Model
{
    /**
     * Attributes
     */
    protected $table = 'patients';

    protected $primaryKey = 'patient_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'address', 'phone', 'birth_date', 'personal_background', 'medical_ensurance_id', 'patient_state_id', 'system_id',
    ];

    public $timestamps = true;

    /**
     * Retorna todos los pacientes
     */
    public static function allFull()
    {
        return Patient::join('medical_ensurances', 'medical_ensurances.medical_ensurance_id', '=', 'patients.medical_ensurance_id')
            ->join('systems', 'systems.system_id', '=', 'patients.system_id')
            ->leftJoin('beds', 'beds.patient_id', '=', 'patients.patient_id')
            ->leftJoin('rooms', 'rooms.room_id', '=', 'beds.room_id')
            ->select('patients.*', 'systems.system', 'rooms.room', 'beds.number AS bed_number')
            ->get();
    }

    /**
     * Retorna el usuario correspondiente al médico
     */
    public static function allFullBySystem($system_id)
    {
        return Patient::where('patients.system_id', '=', $system_id)
            ->join('medical_ensurances', 'medical_ensurances.medical_ensurance_id', '=', 'patients.medical_ensurance_id')
            ->join('systems', 'systems.system_id', '=', 'patients.system_id')
            ->leftJoin('beds', 'beds.patient_id', '=', 'patients.patient_id')
            ->leftJoin('rooms', 'rooms.room_id', '=', 'beds.room_id')
            ->select('patients.*', 'systems.system', 'rooms.room', 'beds.number AS bed_number')
            ->get();
    }

    /**
     * Retorna el paciente con toda su información
     */
    public static function full($patient_id)
    {
        return Patient::where('patients.patient_id', '=', $patient_id)
            ->join('medical_ensurances', 'medical_ensurances.medical_ensurance_id', '=', 'patients.medical_ensurance_id')
            ->join('systems', 'systems.system_id', '=', 'patients.system_id')
            ->join('patient_states', 'patient_states.patient_state_id', '=', 'patients.patient_state_id')
            ->leftJoin('beds', 'beds.patient_id', '=', 'patients.patient_id')
            ->leftJoin('rooms', 'rooms.room_id', '=', 'beds.room_id')
            ->select('patients.*', 'systems.system', 'patient_states.*', 'medical_ensurances.*', 'rooms.room', 'beds.number AS bed_number')
            ->first();
    }

    /**
     * Busca si el paciente ya existe
     */
    public static function dniExists($dni)
    {
        $result = Patient::where('dni', '=', $dni)->count();
        return ($result > 0);
    }

    /**
     * Retorna la obra social del paciente
     */
    public function medicalEnsurance()
    {
        return $this->belongsTo('App\MedicalEnsurance');
    }

    /**
     * Retorna el sistema en el que se encuentra el usuario.
     */
    public function system()
    {
        return $this->belongsTo('App\System', 'system_id');
    }

    /**
     * Retorna el estado del paciente.
     */
    public function state()
    {
        return $this->belongsTo('App\PatientSate', 'patient_state_id');
    }

    /**
     * Retorna la cama del paciente
     */
    public function bed()
    {
        return $this->hasOne('App\Bed');
    }

    /**
     * Retorna los médicos del paciente
     */
    public function medics()
    {
        return User::where([
            ['patient_user.patient_id', '=', $this->patient_id],
            ['roles.role', '=', Role::ROLE_MEDIC],
            ])
            ->join('patient_user', 'patient_user.patient_id', '=', $this->patient_id)
            ->join('role_user', 'role_user.user_id', '=', 'users.user_id')
            ->join('roles', 'roles.role_id', '=', 'role_user.role_id')
            ->select('users.*')
            ->get();
    }
}
