<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemChange;
use App\PatientState;
use App\Permission;
use App\Patient;
use App\System;
use App\Role;
use App\User;

class PatientController extends Controller
{
    /**
     * Validación de datos de paciente
     */
    private function validatePatient($data)
    {
        $this->validate($data, [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'address' => 'sometimes|string|max:255',
            'phone' => 'required|integer',
            'birth_date' => 'required|date',
            'personal_background' => 'string|nullable',
            'family_data' => 'string|nullable',
            'medical_ensurance_id' => 'required|integer|min:1',
            'patient_state_id' => 'integer|min:1',
            'system_id' => 'integer|min:1',
        ]);
    }

    /**
     * Obtener todos los pacientes.
     * 
     * @return JSON.
     */
    public function index()
    {
        return response()->json(Patient::allFull());
    }

    /**
     * Obtener todos los pacientes asignados al usuario médico o jefe de sistema.
     * 
     * @return JSON.
     */
    public function indexAssigned(Request $request)
    {
        $user = User::find($request->user()->user_id);        
        $data = [];
        if ($user->hasRole(Role::ROLE_MEDIC))
        {
            $data = $user->medic()->get()->patients()->get();
        }
        else if ($user->hasRole(Role::ROLE_SYSTEM_CHIEF))
        {
            $system_id = $user->systems()->first()->system_id;
            $data = Patient::allFullBySystem($system_id);
        }
        return response()->json($data);
    }

    /**
     * Retorna solo los pacientes de un sistema
     */
    public function indexBySystem($system_id)
    {
        return response()->json(Patient::allFullBySystem($system_id));
    }

    /**
     * Retorna los pacientes
     */
    public function show($id)
    {
        return response()->json(Patient::full($id));
    }


    /**
     * Guarda los datos de un paciente
     */
    private function save($patient, $data)
    {
        $patient->name = $data->name;
        $patient->lastname = $data->lastname;
        $patient->dni = $data->dni;
        $patient->address = $data->address;
        $patient->phone = $data->phone;
        $patient->birth_date = $data->birth_date;
        $patient->patient_state_id = $data->patient_state_id;
        $patient->system_id = $data->system_id;
        $patient->personal_background = $data->personal_background;
        $patient->family_data = $data->family_data;
        $patient->medical_ensurance_id = $data->medical_ensurance_id;
        $patient->save();
    }

    /**
     * Almacenar un paciente
     */
    public function store(Request $data)
    {
        // Chequeo de camas disponibles
        if (! System::where('system', '=', System::SYSTEM_GUARD)->first()->hasBeds())
        {
            $message = ['status' => 'warning', 'message' => 'No hay camas disponibles en guardia'];
        }
        // Chequeo de DNI existente
        else if (Patient::dniExists($data->dni))
        {
            $message = ['status' => 'warning', 'message' => 'El paciente con ese DNI ya existe en el sistema'];
        }
        else
        {
            // Information try
            // try {
                // Validación de paciente
                $this->validatePatient($data);
                // Nuevo paciente
                // $patient = new Patient;
                // // Almacenamiento de información
                $store_data = $data;
                $store_data->patient_state_id = PatientState::where('patient_state', '=', PatientState::STATE_HOSPITALIZED)->first()->patient_state_id;
                $store_data->system_id = System::find(1)->system_id;
                
                $patient = Patient::createPatient($store_data);
                $patient->setNewSystemById($store_data->system_id);

                // Returning the view
                $message = ['status' => 'success', 'message' => 'Paciente guardado.'];
            // }
            // catch (\Exception $e)
            // {
                // $message = ['status' => 'warning', 'message' => 'Ocurrió un error. Verifica la información ingresada.'];
            // }
        }
        return response()->json($message, 200);
    }


        /**
     * Almacena un paciente
     */
    public function update(Request $data)
    {
        $patient = Patient::find($data['patient_id']);

        // Chequeo que tenga permiso
        if (! $data->user()->hasPermission(Permission::PATIENT_UPDATE)) {
            $message = ['status' => 'warning', 'message' => 'No tienes el permiso para realizar esta acción'];
        }
        // Chequeo de DNI existente
        else if (($patient->dni != $data->dni) && (Patient::dniExists($data->dni))) {
            $message = ['status' => 'warning', 'message' => 'El paciente con ese DNI ya existe en el sistema'];
        }
        else {
            // Information try
            try {
                // Validación de paciente
                // $this->validatePatient();

                // // Almacenamiento de información
                $store_data = $data;
                $store_data->patient_state_id = $patient->patient_state_id;
                $store_data->system_id = $patient->system_id;
                
                $this->save($patient, $store_data);

                $patient->setNewSystemById($store_data->system_id);
                $patient->save();

                // Returning the view
                $message = ['status' => 'success', 'message' => 'Paciente guardado'];
            }
            catch (\Exception $e)
            {
                $message = ['status' => 'warning', 'message' => $e->errorInfo[2]];
            }
        }
        return response()->json($message, 200);
    }

    /**
     * Cambia un paciente de systema
     */
    public function changeSystem(Request $data)
    {
        $new_system = System::find($data->system_id);
        $old_system = System::find(Patient::find($data->patient_id)->system_id);
        
        // Chequeo que tenga permiso
        if (! $data->user()->hasPermission(Permission::PATIENT_UPDATE))
        {
            $message = ['status' => 'warning', 'message' => 'No tienes el permiso para realizar esta acción'];
        }
        // Chqueo que haya camas en el nuevo sistema
        else if (! $new_system->hasBeds())
        {
            $message = ['status' => 'warning', 'message' => 'El sistema no tiene camas disponibles'];
        }
        else
        {
            // try {
                // Validación de paciente
                // $this->validateNewSystem();
                
                // Nuevo paciente
                $patient = Patient::find($data->patient_id);
                $patient->setNewSystemById($new_system->system_id);
                // Asentar el cambio de sistema
                $patient->storeSystemChange($old_system->system, $new_system->system, $data->user()->user_id);
                $patient->save();

                // Returning the view
                $message = ['status' => 'success', 'message' => 'Cambiaste a '.$patient->name.' '.$patient->lastname.' de '.$old_system->system.' a '.$new_system->system];
            
        }
        return response()->json($message, 200);
    }


    /**
     * Retorna los medicos asignados al paciente y los posibles médicos a asignar
     */
    public function medics($patient_id)
    {
        $patient = Patient::find($patient_id);
        
        return response()->json([
            'medics' => $patient->medicsFull(),
            'posible_medics' => $patient->posibleMedics(),
        ]);
    }


    /**
     * Retorna los medicos asignados al paciente y los posibles médicos a asignar
     */
    public function addMedic(Request $data)
    {
        $patient = Patient::find($data->patient_id);

        if ($patient->hasMedic($data->medic_id))
        {
            $message = ['status' => 'warning', 'message' => 'El paciente ya tiene asignado al médico.'];
        }
        else
        {
            $patient->addMedic($data->medic_id);

            // Returning the view
            $message = ['status' => 'success', 'message' => 'Medico asignado con éxito'];
        }
        return response()->json($message, 200);
    }


    /**
     * Retorna los medicos asignados al paciente y los posibles médicos a asignar
     */
    public function removeMedic(Request $data)
    {
        $patient = Patient::find($data->patient_id);

        if (! $patient->hasMedic($data->medic_id))
        {
            $message = ['status' => 'warning', 'message' => 'El paciente no tiene asignado al médico.'];
        }
        else
        {
            $patient->removeMedic($data->medic_id);

            // Returning the view
            $message = ['status' => 'success', 'message' => 'El médico ya no está asignado al paciente.'];
        }
        return response()->json($message, 200);
    }



        /**
     * Retorna los medicos asignados al paciente y los posibles médicos a asignar
     */
    public function clinicData($patient_id)
    {
        $patient = Patient::find($patient_id); // Obtener paciente
        
        $clinicData = []; // Inicializar para la información completa del paciente

        $entries = $patient->entries()->orderBy('date', 'DESC')->get(); // Obtener entradas al hospital

        foreach ($entries as $entry) { // Para cada entrada obtener las hospitalizaciones
            
            $hospitalizations = $entry->hospitalizations()->join('systems', 'systems.system_id', '=','hospitalizations.system_id')->orderBy('date_of_admission', 'DESC')->get();

            foreach ($hospitalizations as $hospitalization) { // Para cada entrada obtener las hospitalizaciones
                $hospitalization['evolutions'] = $hospitalization->evolutions()->orderBy('date', 'DESC')->get();
            }

            $completeEntry = $entry;
            $completeEntry['hospitalizations'] = $hospitalizations;
            array_push($clinicData, $completeEntry);
        }

        return response()->json([
            'clinicData' => $clinicData,
            'lastEvolutions' => $patient->lastEvolutions(),
            ]);
    }
}
