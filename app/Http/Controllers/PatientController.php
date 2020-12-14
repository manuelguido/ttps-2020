<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
     * 
     * @return void.
     */
    private function validatePatient($data)
    {
        $this->validate($data, [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'address' => 'sometimes|string|max:255',
            'phone' => 'required|integer',
            'dni' => 'required|integer|min:1|max:999999999',
            'birth_date' => 'required|date',
            'personal_background' => 'string|nullable',
            'medical_ensurance_id' => 'required|integer|min:1',
            'patient_state_id' => 'sometimes|integer|min:1',
            'system_id' => 'sometimes|integer|min:1',
            'email' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_lastname' => 'required|string|max:255',
            'contact_phone' => 'required|integer',
        ]);
    }

    /**
     * Validación de datos de paciente
     * 
     * @return void.
     */
    private function validatePatientEntry($data)
    {
        $this->validate($data, [
            'actual_disease' => 'required|string|max:255',
            'date_of_symptoms' => 'required|date',
            'date_of_diagnosis' => 'required|date',
            'date_of_admission' => 'required|date',
        ]);
    }

    /**
     * Validación de dni de paciente
     * 
     * @return void.
     */
    private function validatePatientDni($data)
    {
        $this->validate($data, [
            'dni' => 'required|integer|min:1|max:999999999',
        ]);
    }

    /**
     * Validación de id de paciente
     * 
     * @return void.
     */
    private function validatePatientId($data)
    {
        $this->validate($data, [
            'patient_id' => 'required|integer|min:1',
        ]);
    }

    /**
     * Validación de id de sistema
     * 
     * @return void.
     */
    private function validateSystemId($data)
    {
        $this->validate($data, [
            'system_id' => 'required|integer|min:1',
        ]);
    }

    /**
     * Obtener todos los pacientes.
     * 
     * @return JSON.
     */
    public function index()
    {
        return response()->json(Patient::allFullByState(PatientState::STATE_HOSPITALIZED));
    }

    /**
     * Obtener todos los pacientes asignados al usuario médico o jefe de sistema.
     * 
     * @return JSON.
     */
    public function indexAssigned(Request $request)
    {
        $user = User::find($request->user()->user_id);
        $responseData = [];
        if ($user->hasRole(Role::ROLE_MEDIC)) {
            $responseData = $user->medic()->get()->patients()->get();
        } else if ($user->hasRole(Role::ROLE_SYSTEM_CHIEF)) {
            $system_id = $user->systems()->first()->system_id;
            $responseData = Patient::allFullBySystemByState($system_id, PatientState::STATE_HOSPITALIZED);
        }
        return response()->json($responseData);
    }

    /**
     * Obtener solo los pacientes de un sistema.
     * 
     * @return JSON.
     */
    public function indexBySystem($system_id)
    {
        return response()->json(Patient::allFullBySystemByState($system_id, PatientState::STATE_HOSPITALIZED));
    }

    /**
     * Obtener los pacientes.
     * 
     * @return JSON.
     */
    public function show($id)
    {
        return response()->json(Patient::full($id));
    }

    /**
     * Almacenar un paciente.
     * 
     * @return JSON.
     */
    public function store(Request $data)
    {
        // Chequeo de camas disponibles
        if (!System::where('system', '=', System::SYSTEM_GUARD)->first()->hasBeds()) {
            $message = ['status' => 'warning', 'message' => 'No hay camas disponibles en guardia'];
        }
        // Chequeo de DNI existente
        else if (Patient::dniExists($data->dni)) {
            $message = ['status' => 'warning', 'message' => 'El paciente con ese DNI ya existe en el sistema'];
        } else {
            // Information try
            try {
                // Validación de paciente
                $this->validatePatient($data);
                $this->validatePatientEntry($data);

                // Nuevo paciente
                $patient = new Patient;
                $store_data = $data;
                $store_data->patient_state_id = PatientState::where('patient_state', '=', PatientState::STATE_HOSPITALIZED)->first()->patient_state_id;
                $store_data->system_id = System::find(1)->system_id;
                $patient = Patient::createPatient($store_data);

                // Mensaje
                $message = ['status' => 'success', 'message' => 'Paciente e internación guardadas.'];
            } catch (\Exception $e) {
                $message = ['status' => 'warning', 'message' => 'Ocurrió un error. Verifica la información ingresada.'];
            }
        }
        return response()->json($message, 200);
    }

    /**
     * Almacenar un paciente.
     * 
     * @return JSON.
     */
    public function update(Request $data)
    {
        $patient = Patient::find($data['patient_id']);

        // Chequeo que tenga permiso
        if (!$data->user()->hasPermission(Permission::PATIENT_UPDATE)) {
            $message = ['status' => 'warning', 'message' => 'No tienes el permiso para realizar esta acción'];
        }
        // Chequeo de DNI existente
        else if (($patient->dni != $data->dni) && (Patient::dniExists($data->dni))) {
            $message = ['status' => 'warning', 'message' => 'El paciente con ese DNI ya existe en el sistema'];
        } else {
            // Information try
            try {
                // Validación de paciente
                $this->validatePatient($data);
                $this->validatePatientEntry($data);

                // Almacenamiento de información
                $store_data = $data;
                $store_data->patient_state_id = $patient->patient_state_id;
                $store_data->system_id = $patient->system_id;

                $this->save($patient, $store_data);

                $patient->setNewSystemById($store_data->system_id);
                $patient->save();

                // Returning the view
                $message = ['status' => 'success', 'message' => 'Paciente guardado'];
            } catch (\Exception $e) {
                $message = ['status' => 'warning', 'message' => $e->errorInfo[2]];
            }
        }
        return response()->json($message, 200);
    }

    /**
     * Cambiar un paciente de sistema.
     * 
     * @return JSON.
     */
    public function changeSystem(Request $data)
    {
        // try {
            $this->validatePatientId($data);
            $this->validateSystemId($data);

            $patient = Patient::find($data->patient_id);
            $newSystem = System::find($data->system_id);
            $oldSystem = System::find($patient->system_id);

            if (!$newSystem->hasBeds()) {
                $message = ['status' => 'warning', 'message' => 'El sistema no tiene camas disponibles'];
            } else {
                // Cambiar sistema
                $patient->changeSystem($oldSystem, $newSystem, $data->user()->user_id);
            
                $message = ['status' => 'success', 'message' => 'Cambiaste a ' . $patient->name . ' ' . $patient->lastname . ' de ' . $oldSystem->system . ' a ' . $newSystem->system, 'patient' => Patient::full($patient->patient_id)];
            }
        // } catch (\Exception $e) {
            // $message = ['status' => 'error', $e[0]];
        // }    
        return response()->json($message, 200);
    }


    /**
     * Obtener medicos asignados al paciente y los posibles médicos a asignar.
     * 
     * @return JSON.
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
     * Asignar médico a paciente.
     * 
     * @return JSON.
     */
    public function addMedic(Request $data)
    {
        $patient = Patient::find($data->patient_id);

        if ($patient->hasMedic($data->medic_id)) {
            $message = ['status' => 'warning', 'message' => 'El paciente ya tiene asignado al médico.'];
        } else {
            $patient->addMedic($data->medic_id);

            // Returning the view
            $message = ['status' => 'success', 'message' => 'Medico asignado con éxito'];
        }
        return response()->json($message, 200);
    }


    /**
     * Desasignar médico a un paciente.
     * 
     * @return JSON.
     */
    public function removeMedic(Request $data)
    {
        $patient = Patient::find($data->patient_id);

        if (!$patient->hasMedic($data->medic_id)) {
            $message = ['status' => 'warning', 'message' => 'El paciente no tiene asignado al médico.'];
        } else {
            $patient->removeMedic($data->medic_id);

            // Returning the view
            $message = ['status' => 'success', 'message' => 'El médico ya no está asignado al paciente.'];
        }
        return response()->json($message, 200);
    }


    /**
     * Obtener un paciente por su dni.
     * 
     * @return JSON.
     */
    public function searchByDni(Request $request)
    {
        $this->validatePatientDni($request);

        $patient = Patient::where('dni', '=', $request->dni)->first();
        if ($patient) {
            if ($patient->isOnInternation()) {
                $responseData = ['status' => 'warning', 'message' => 'El paciente ya se encuentra en internación.'];
            } else {
                $responseData = ['status' => 'success', 'message' => 'Se encontró el paciente.', 'patient' => $patient];
            }
        } else {
            $responseData = ['status' => 'success', 'message' => 'No se encontró el paciente.'];
        }
        return response()->json($responseData);
    }

    /**
     * Retorna los medicos asignados al paciente y los posibles médicos a asignar
     */
    public function clinicData($patient_id)
    {
        $patient = Patient::find($patient_id); // Obtener paciente

        $clinicData = []; // Inicializar para la información completa del paciente

        $evolutions = $patient->currentEvolutions()->get();

        $systemChanges = $patient->systemChanges();

        
        // foreach ($entries as $entry) { // Para cada entrada obtener las hospitalizaciones

        //     $hospitalizations = $entry->hospitalizations()->join('systems', 'systems.system_id', '=', 'hospitalizations.system_id')->orderBy('date_of_admission', 'DESC')->get();

        //     foreach ($hospitalizations as $hospitalization) { // Para cada entrada obtener las hospitalizaciones
        //         $hospitalization['evolutions'] = $hospitalization->evolutions()->orderBy('date', 'DESC')->get();
        //     }

        //     $completeEntry = $entry;
        //     $completeEntry['hospitalizations'] = $hospitalizations;
        //     array_push($clinicData, $completeEntry);
        // }

        return response()->json([
            'clinicData' => $patient->currentEvolutions()->get(),
            // 'lastEvolutions' => $patient->lastEvolutions(),
        ]);
    }
}
