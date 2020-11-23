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
     * Obtener la cama del paciente.
     * 
     * @return App\Bed.
     */
    public function bed()
    {
        return $this->hasOne('App\Bed');
    }

    /**
     * Obtener el estado del paciente.
     * 
     * @return App\PatientSate.
     */
    public function state()
    {
        return $this->belongsTo('App\PatientSate', 'patient_state_id');
    }

    /**
     * Obtener la obra social del paciente.
     * 
     * @return App\MedicalEnsurance.
     */
    public function medicalEnsurance()
    {
        return $this->belongsTo('App\MedicalEnsurance');
    }

    /**
     * Obtener el sistema en el que se encuentra el usuario.
     * 
     * @return App\System.
     */
    public function system()
    {
        return $this->belongsTo('App\System', 'system_id');
    }

    /**
     * Obtener las entradas al hospital del paciente.
     * 
     * @return App\Emtry Collection.
     */
    public function entries()
    {
        return $this->hasMany('App\Entry');
    }

    /**
     * Obtener los cambios de sistema del paciente.
     * 
     * @return App\SystemChange Collection.
     */
    public function systemChanges()
    {
        return $this->hasMany('App\SystemChange');
    }

    /**
     * Obtener las notificaciones del paciente.
     * 
     * @return App\Alert.
     */
    public function alerts()
    {
        return $this->hasMany('App\Alert');
    }

    /**
     * Obtener los pacientes asignados del médico.
     * 
     * @return App\Patient.
     */
    public function medics()
    {
        return $this->belongsToMany('App\Patient');
    }

    /**
     * Obtener los pacientes asignados del médico.
     * 
     * @return App\Patient.
     */
    public function medicsFull()
    {
        return $this->medics()->join('users', 'users.user_id', '=', 'medics.user_id')->get();
    }

    /**
     * Obtener los médicos posibles para que puedan ser asignados al paciente.
     * Solo se obtienen los de su mismo sistema.
     * 
     * @return Object Collection.
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
    }


    /**
     * Obtener todos los pacientes.
     * 
     * @return Object Collection.
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
     * @return Object.
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
     * 
     * @return Object.
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
     * Determina si el paciente con el DNI existe.
     * 
     * @return Boolean.
     */
    public static function dniExists($dni)
    {
        return (Patient::where('dni', '=', $dni)->count() > 0);
    }

    /**
     * Asentar el cambio de sistema.
     * 
     * @return void.
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
     * Liberar la cama del paciente.
     * 
     * @return void.
     */
    public function freeCurrentBed()
    {
        $bed = Bed::where('patient_id', '=', $this->patient_id)->first(); //Obtener cama actual

        if ($bed != NULL)
        {
            $bed->is_occupied = False;
            $bed->patient_id = NULL;
            $bed->save();
        }
    }


    /**
     * Cambiar paciente de sistema.
     * 
     * @return void.
     */
    public function setNewSystemById($new_system_id)
    {
        $this->freeCurrentBed(); // Liberar la cama actual del sistema
        $system = System::find($new_system_id); // Obtener nuevo sistema
        $system->ocuppyNewBed($this->patient_id); // Enviar al sistema que ocupe una nueva cama para este paciente
        $this->system_id = $new_system_id; // Acutalizo el id de sistema del paciente 
        $this->save();
    }


    /**
     * Chequea si el paciente tiene asignado a un medico por el id de usuario del médico.
     * 
     * @return Boolean.
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
     * Añade un médico por su id.
     * 
     * @return void.
     */
    public function addMedic($user_id)
    {
        DB::table('patient_user')->insert(['user_id' => $user_id, 'patient_id' => $this->patient_id]);
    }


    /**
     * Elimina a un médico por su id.
     * 
     * @return void.
     */
    public function removeMedic($user_id)
    {
        DB::table('patient_user')->where(['user_id' => $user_id, 'patient_id' => $this->patient_id])->delete();
    }
}
