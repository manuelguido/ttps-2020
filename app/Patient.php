<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\PatientState;
use App\System;
use App\Medic;
use App\Alert;
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
        'name', 'lastname', 'address', 'phone', 'birth_date', 'personal_background', 'email',
        'medical_ensurance_id', 'patient_state_id', 'system_id',
        'contact_name', 'contact_lastname', 'contact_phone',
    ];

    public $timestamps = true;

    /**
     * Crear paciente
     * 
     * @return App\Patient;
     */
    public static function createPatient($data)
    {
        $patient = new Patient;
        $patient->saveData($data);
        $newEntry = $patient->addEntry($data);
        $patient->setInitialSystem();
        return $patient;
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
            ->join('patient_states', 'patient_states.patient_state_id', '=', 'patients.patient_state_id')
            ->leftJoin('beds', 'beds.patient_id', '=', 'patients.patient_id')
            ->leftJoin('rooms', 'rooms.room_id', '=', 'beds.room_id')
            ->select('patients.*', 'systems.system', 'rooms.room', 'beds.number AS bed_number')
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    /**
     * Obtener todos los pacientes por estados.
     * 
     * @return Object Collection.
     */
    public static function allFullByState($state)
    {
        return Patient::where('patient_states.patient_state', '=', $state)
            ->join('medical_ensurances', 'medical_ensurances.medical_ensurance_id', '=', 'patients.medical_ensurance_id')
            ->join('systems', 'systems.system_id', '=', 'patients.system_id')
            ->join('patient_states', 'patient_states.patient_state_id', '=', 'patients.patient_state_id')
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
            ->join('patient_states', 'patient_states.patient_state_id', '=', 'patients.patient_state_id')
            ->leftJoin('beds', 'beds.patient_id', '=', 'patients.patient_id')
            ->leftJoin('rooms', 'rooms.room_id', '=', 'beds.room_id')
            ->select('patients.*', 'systems.system', 'rooms.room', 'beds.number AS bed_number')
            ->orderBy('updated_at', 'DESC')
            ->get();
    }


    /**
     * Obtener los pacientes de un sistema específico por estado.
     * 
     * @return Object.
     */
    public static function allFullBySystemByState($system_id, $state)
    {
        return Patient::where([
            ['patients.system_id', '=', $system_id],
            ['patient_states.patient_state', '=', $state],
            ])
            ->join('medical_ensurances', 'medical_ensurances.medical_ensurance_id', '=', 'patients.medical_ensurance_id')
            ->join('systems', 'systems.system_id', '=', 'patients.system_id')
            ->join('patient_states', 'patient_states.patient_state_id', '=', 'patients.patient_state_id')
            ->leftJoin('beds', 'beds.patient_id', '=', 'patients.patient_id')
            ->leftJoin('rooms', 'rooms.room_id', '=', 'beds.room_id')
            ->select('patients.*', 'systems.system', 'rooms.room', 'beds.number AS bed_number')
            ->orderBy('updated_at', 'DESC')
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
     * Obtener las últimas evoluciones de un paciente
     * 
     * @return Collection.
     */
    public function lastEvolutions($limit = 5)
    {
        return Evolution::where('entries.patient_id', $this->patient_id)
            ->join('hospitalizations', 'hospitalizations.hospitalization_id', '=', 'evolutions.hospitalization_id')
            ->join('entries', 'entries.entry_id', '=', 'hospitalizations.entry_id')
            ->orderBy('evolutions.created_at', 'DESC')
            ->select('evolutions.*')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtener la útlima evolución del paciente. 
     * 
     * @return Collection.
     */
    public function lastEvolution()
    {        
        return Evolution::where('entries.patient_id', $this->patient_id)
            ->join('hospitalizations', 'hospitalizations.hospitalization_id', '=', 'evolutions.hospitalization_id')
            ->join('entries', 'entries.entry_id', '=', 'hospitalizations.entry_id')
            ->orderBy('evolutions.created_at', 'DESC')
            ->select('evolutions.*')
            ->first();
    }

    /**
     * Obtener la anteútlima evolución del paciente. 
     * 
     * @return Collection.
     */
    public function previousEvolution()
    {
        return Evolution::where([
            ['entries.patient_id', '=', $this->patient_id],
            ['evolutions.evolution_id', '<>', $this->lastEvolution()->evolution_id],
            ])
            ->join('hospitalizations', 'hospitalizations.hospitalization_id', '=', 'evolutions.hospitalization_id')
            ->join('entries', 'entries.entry_id', '=', 'hospitalizations.entry_id')
            ->orderBy('evolutions.created_at', 'DESC')
            ->select('evolutions.*')
            ->first();
    }

    /**
     * Obtener las evoluciones de la internación actual del paciente. 
     * 
     * @return Collection.
     */
    public function currentEvolutions()
    {
        return Evolution::where([
            ['entries.patient_id', '=', $this->patient_id],
            ['entries.entry_id', '=', $this->currentEntry()->entry_id],
            ])
            ->join('hospitalizations', 'hospitalizations.hospitalization_id', '=', 'evolutions.hospitalization_id')
            ->join('entries', 'entries.entry_id', '=', 'hospitalizations.entry_id')
            ->leftJoin('ventilatory_mechanics', 'evolutions.ventilatory_mechanic_id', '=', 'ventilatory_mechanics.ventilatory_mechanic_id')
            ->leftJoin('oxigen_requirement_types', 'evolutions.oxigen_requirement_type_id', '=', 'oxigen_requirement_types.oxigen_requirement_type_id')
            ->leftJoin('feeding_types', 'evolutions.feeding_type_id', '=', 'feeding_types.feeding_type_id')
            ->orderBy('evolutions.created_at', 'DESC')
            ->select('evolutions.*', 'ventilatory_mechanics.*', 'oxigen_requirement_types.*', 'feeding_types.*');
    }

    /**
     * Obtener los cambios del sistema del paciente. 
     * (Ineficiente: Buscar manera de optimizar en una sola consulta un doble join a una misma tabla)
     * @return Collection.
     */
    public function systemChanges()
    {
        $systemChanges = $this->currentEntry()->hospitalizations()
            ->join('systems', 'systems.system_id', '=', 'hospitalizations.system_id')
            ->select('hospitalizations.*', 'systems.system')
            ->get();

        foreach ($systemChanges as $sc) {
            if($sc->previous_system_id) {
                $sc->previous_system = System::find($sc->previous_system_id)->system;
            } else {
                $sc->previous_system = null;
            }
        }

        return $systemChanges;
    }

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
    public function patientState()
    {
        return PatientState::where('patient_state_id', '=', $this->patient_state_id)->first();
        // return $this->belongsTo('App\PatientState', 'patient_state_id');
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
        return System::where('system_id', '=', $this->system_id);
        // return $this->belongsTo('App\System');
    }

    /**
     * Obtener las entradas al hospital del paciente.
     * 
     * @return App\Emtry Collection.
     */
    public function entries()
    {
        return Entry::where('patient_id', '=', $this->patient_id);
        // return $this->hasMany('App\Entry', 'entry_id', 'patient_id');
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
        return Medic::join('patient_medic', 'patient_medic.medic_id', '=', 'medics.medic_id')->where('patient_medic.patient_id', '=', $this->patient_id);
    }

    /**
     * Obtener los pacientes asignados del médico con la información de usuario.
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
        $assigned = $this->medicsFull();

        $allMedics = Medic::where('system_user.system_id', '=', $this->system_id)
            ->join('users', 'medics.user_id', '=', 'users.user_id')
            ->join('system_user', 'system_user.user_id', '=', 'users.user_id')
            ->get();

        $notAssigned = [];
        
        foreach ($allMedics as $medic) {
            $isIn = false;
            foreach ($assigned as $current) {
                if ($medic->medic_id == $current->medic_id) {
                    $isIn = true;
                    break;
                }
            }
            if (!$isIn) {
                array_push($notAssigned, $medic);
            }
        }

        return $notAssigned;
    }

    /**
     * Obtener entrada actual del paciente al hospital.
     * 
     * @return App\Entry.
     */
    public function currentEntry()
    {
        return Entry::where('patient_id', '=', $this->patient_id)->orderBy('date', 'DESC')->first();
    }

    /**
     * Actualizar información de un paciente
     * 
     * @return void.
     */
    public function updateData($data)
    {
        $this->saveData($data);
    }

    /**
     * Actualizar información de un paciente
     * 
     * @return void.
     */
    private function saveData($data)
    {
        $this->name = $data->name;
        $this->lastname = $data->lastname;
        $this->dni = $data->dni;
        $this->address = $data->address;
        $this->phone = $data->phone;
        $this->birth_date = $data->birth_date;
        $this->patient_state_id = $data->patient_state_id;
        $this->system_id = $data->system_id;
        $this->personal_background = $data->personal_background;
        $this->medical_ensurance_id = $data->medical_ensurance_id;
        $this->email = $data->email;
        $this->contact_name = $data->contact_name;
        $this->contact_lastname = $data->contact_lastname;
        $this->contact_phone = $data->contact_phone;
        $this->save();
    }

    /**
     * Añadir una entrada del paciente al hospital.
     * El conjuto de entradas es la historia clinica del paciente.
     * La entrada tiene hospitalizaciones.
     * Las hospitalizaciones tienen las evoluciones.
     * 
     * @return App\Entry.
     */
    public function addEntry($data)
    {
        $entry = new Entry;
        $entry->patient_id = $this->patient_id;
        $entry->date = Carbon::now('America/Argentina/Buenos_Aires');
        $entry->time = Carbon::now('America/Argentina/Buenos_Aires');
        $entry->actual_disease = $data['actual_disease'];
        $entry->date_of_symptoms = $data['date_of_symptoms'];
        $entry->date_of_diagnosis = $data['date_of_diagnosis'];
        $entry->date_of_admission = $data['date_of_admission'];
        $entry->date_of_death = $data['date_of_death'];
        $entry->date_of_exit = $data['date_of_exit'];

        $entry->save();
        return $entry;
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
     * Desasignar todos los médicos de un paciente.
     * 
     * @return void.
     */
    private function unassignMedics()
    {
        DB::table('patient_medic')->where('patient_id', '=', $this->patient_id)->delete();
    }

    /**
     * Asentar el cambio de sistema.
     * 
     * @return void.
     */
    public function changeSystem($old_system, $new_system, $userId)
    {
        // Texto para la alerta
        $textData = "El paciente ".$this->name." ".$this->lastname." fue cambiado del sistema ".$old_system->system." a ".$new_system->system." .";

        // Crear alerta a los medicos
        foreach ($this->medicsFull() as $medic) {
            Alert::createAlert($this->patient_id, $medic, $textData);
        }

        // Crear alerta al jefe del sistema
        $chief = $this->system()->first()->chief()->first();
        Alert::createAlert($this->patient_id, $chief, $textData);

        // Desasignar todos los pacientes
        $this->unassignMedics();

        // Cambiar el sistema en si
        $entry = $this->currentEntry();
        $entry->addHospitalization($new_system->system_id, $old_system->system_id); // Añadir hospitalización a la internación actual
        $this->freeCurrentBed(); // Liberar la cama actual del sistema
        $new_system->ocuppyNewBed($this->patient_id); // Enviar al sistema que ocupe una nueva cama para este paciente
        $this->system_id = $new_system->system_id; // Acutalizo el id de sistema del paciente 
        $this->save();
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
    public function setInitialSystem()
    {
        $entry = $this->currentEntry(); // Obtener ultima entrada del paciente
        $guard = System::where('system', System::SYSTEM_GUARD)->first(); // Id de sistema guardia
        $entry->addHospitalization($guard->system_id); // Añadir hospitalización a la internación actual
        $guard->ocuppyNewBed($this->patient_id); // Enviar al sistema que ocupe una nueva cama para este paciente
        $this->system_id = $guard->system_id; // Acutalizo el id de sistema del paciente 
        $this->save();
    }

    /**
     * Chequea si el paciente tiene asignado a un medico por el id de usuario del médico.
     * 
     * @return Boolean.
     */
    public function hasMedic($medic_id)
    {
        $result = DB::table('patient_medic')->where([
            ['medic_id', '=', $medic_id],
            ['patient_id', '=', $this->patient_id]
            ])
            ->count();

        return ($result > 0);
    }


    /**
     * Añade un médico por su id.
     * 
     * @return void.
     */
    public function addMedic($medic_id)
    {
        DB::table('patient_medic')->insert(['medic_id' => $medic_id, 'patient_id' => $this->patient_id]);

        $textData = "Fuiste asignado al paciente ".$this->name." ".$this->lastname." (DNI ".$this->dni.")";
        $medic = Medic::find($medic_id);
        Alert::createAlert($this->patient_id, $medic, $textData);
    }


    /**
     * Elimina a un médico por su id.
     * 
     * @return void.
     */
    public function removeMedic($medic_id)
    {
        DB::table('patient_medic')->where(['medic_id' => $medic_id, 'patient_id' => $this->patient_id])->delete();
        
        $textData = "Fuiste desasignado del paciente ".$this->name." ".$this->lastname." (DNI ".$this->dni.")";
        $medic = Medic::find($medic_id);
        Alert::createAlert($this->patient_id, $medic, $textData);
    }

    /**
     * Obtener la hospitalización actual del paciente.
     * 
     * @return App\Hospitalization.
     */
    public function currentHospitalization()
    {
        return Hospitalization::where('entries.patient_id', '=', $this->patient_id)
            ->join('entries', 'entries.entry_id', '=', 'hospitalizations.entry_id')
            ->orderBy('hospitalizations.hospitalization_id', 'DESC')
            ->select('hospitalizations.*')
            ->first();
    }

    /**
     * Obtener si el paciente ya se encuentra hospitalizado.
     * 
     * @return Booelan.
     */
    public function isOnInternation()
    {
        return ($this->patientState()->patient_state == PatientState::STATE_HOSPITALIZED);
    }

    /**
     * Cambiar estado de un paciente.
     * 
     * @return void.
     */
    private function setStatus($state)
    {
        $patientState = PatientState::where('patient_state', '=', $state)->first();
        $this->patient_state_id = $patientState->patient_state_id;
        $this->save();
    }
    
    /**
     * Declarar paciente en egreso.
     * 
     * @return void.
     */
    public function declareExit()
    {
        $this->setStatus(PatientState::STATE_DISCHARGED);
        $textData = "El paciente ".$this->name." ".$this->lastname." ha sido dado de alta.";
        $this->alertAssignedUsers($textData);
        $this->unassignMedics();
    }

    /**
     * Declarar paciente en óbito.
     * 
     * @return void.
     */
    public function declareDeath()
    {
        $this->setStatus(PatientState::STATE_DEATH);
        $textData = "El paciente ".$this->name." ".$this->lastname." ha sido declarado en óbito.";
        $this->alertAssignedUsers($textData);
        $this->unassignMedics();
    }

    /**
     * Crear alerta para todos los medicos y el jefe de sistema del usuario.
     * 
     * @return void.
     */
    public function alertAssignedUsers($textData)
    {
        // Crear alerta a los medicos
        foreach ($this->medicsFull() as $medic) {
            Alert::createAlert($this->patient_id, $medic, $textData);
        }
        
        // Crear alerta al jefe del sistema
        $chief = $this->system()->first()->chief()->first();
        Alert::createAlert($this->patient_id, $chief, $textData);
        
    }
}
