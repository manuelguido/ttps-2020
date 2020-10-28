<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SystemChange;
use App\User;
use DB;

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
     * Obtener todos los pacientes.
     * 
     */
    public static function allFull()
    {
        return Patient::join('medical_ensurances', 'medical_ensurances.medical_ensurance_id', '=', 'patients.medical_ensurance_id')
            ->join('systems', 'systems.system_id', '=', 'patients.system_id')
            ->leftJoin('beds', 'beds.patient_id', '=', 'patients.patient_id')
            ->leftJoin('rooms', 'rooms.room_id', '=', 'beds.room_id')
            ->select('patients.*', 'systems.system', 'rooms.room', 'beds.number AS bed_number')
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    /**
     * Obtener los pacientes de un sistema específico.
     * 
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
     * Obtener el paciente con toda su información externa a la entidad.
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
     * Determina (true false) si el paciente con el DNI existe.
     * 
     */
    public static function dniExists($dni)
    {
        $result = Patient::where('dni', '=', $dni)->count();
        return ($result > 0);
    }


    /**
     * Obtener la obra social del paciente.
     * 
     * 
     */
    public function medicalEnsurance()
    {
        return $this->belongsTo('App\MedicalEnsurance');
    }


    /**
     * Obtener el sistema en el que se encuentra el usuario.
     * 
     */
    public function system()
    {
        return $this->belongsTo('App\System', 'system_id');
    }


    /**
     * Obtener el estado del paciente.
     * 
     */
    public function state()
    {
        return $this->belongsTo('App\PatientSate', 'patient_state_id');
    }


    /**
     * Obtener la cama del paciente.
     * 
     */
    public function bed()
    {
        return $this->hasOne('App\Bed');
    }


    /**
     * Obtener los médicos del paciente.
     * 
     */
    public function medics()
    {
        return User::where([
            ['patient_user.patient_id', '=', $this->patient_id],
            ['roles.role', '=', Role::ROLE_MEDIC],
            ])
            ->join('patient_user', 'patient_user.user_id', '=', 'users.user_id')
            ->join('role_user', 'role_user.user_id', '=', 'users.user_id')
            ->join('roles', 'roles.role_id', '=', 'role_user.role_id')
            ->select('users.*')
            ->get();
    }

    /**
     * Obtener los médicos asignables del paciente.
     * SOLO LOS DE SU MISMO SISTEMA QUE NO TIENE ASIGNADOS AÜN.
     * 
     */
    public function posibleMedics()
    {
        return User::where('roles.role', '=', Role::ROLE_MEDIC)
            ->join('role_user', 'role_user.user_id', '=', 'users.user_id')
            ->join('roles', 'roles.role_id', '=', 'role_user.role_id')
            ->leftJoin('system_user', 'system_user.user_id', '=', 'users.user_id')
            ->leftJoin('systems', 'systems.system_id', '=', 'system_user.system_id')
            ->whereNotIn('users.user_id', $this->medics()->toArray())
            ->get();
        // return User::where([
        //     ['roles.role', '=', Role::ROLE_MEDIC],
        //     ])
        //     ->join('patient_user', 'patient_user.user_id', '=', 'users.user_id')
        //     ->join('role_user', 'role_user.user_id', '=', 'users.user_id')
        //     ->join('roles', 'roles.role_id', '=', 'role_user.role_id')
        //     ->select('users.*')
        //     ->whereNotIn('users.user_id',
        //         $this->medics()->toArray()
        //     )
        //     ->get();
    }


    /**
     * Obtener los cambios de sistema del paciente.
     * 
     */
    public function systemChanges()
    {
        return $this->hasMany('App\SystemChange');
    }


    /**
     * Asentar el cambio de sistema.
     * 
     */
    public function storeSystemChange($old, $new, $user_id)
    {
        $system_change = new SystemChange;
        $system_change->patient_id = $this->patient_id;
        $system_change->user_id = $user_id;
        $system_change->old_system = $old;
        $system_change->new_system = $new;
        $system_change->save();
    }


    /**
     * Liberar la cama del paciente
     */
    public function freeCurrentBed()
    {
        $bed = Bed::where('patient_id', '=', $this->patient_id)->first();

        if ($bed != NULL) {
            $bed->is_occupied = False;
            $bed->patient_id = NULL;
            $bed->save();
        }
    }


    /**
     * Cambiar paciente de sistema
     */
    public function setNewSystemById($new_system_id)
    {
        // Liberar la cama actual del sistema
        $this->freeCurrentBed();
        
        // // Aumentar en 1 las camas del nuevo sistema
        $system = System::find($new_system_id);

        // Enviar al sistema que ocupe una nueva cama para este paciente
        $system->ocuppyNewBed($this->patient_id);

        // Acutalizo el id de sistema del paciente
        $this->system_id = $new_system_id;
        $this->save();
    }


    /**
     * Chequea si el paciente tiene asignado a un medico por su ID
     */
    public function hasMedic($user_id)
    {
        $result = User::where([
            ['patient_user.user_id', '=', $user_id],
            ['patient_user.patient_id', '=', $this->patient_id]
            ])
            ->join('patient_user', 'patient_user.user_id', '=', 'users.user_id')
            ->count();

        return ($result > 0);
    }


    /**
     * Añade un médico por su id
     */
    public function addMedic($user_id)
    {
        DB::table('patient_user')->insert([
            'user_id' => $user_id,
            'patient_id' => $this->patient_id,
        ]);
    }


    /**
     * Añade un médico por su id
     */
    public function removeMedic($user_id)
    {
        DB::table('patient_user')->where([
            'user_id' => $user_id,
            'patient_id' => $this->patient_id,
        ])->delete();
    }
}
