<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PatientState;
use App\Permission;
use App\Settings;
use App\Patient;
use App\System;
use App\Role;
use App\User;
use Carbon\Carbon;

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
        $responseData = $responseData = $user->medic()->patients()->get();
        if ($user->hasRole(Role::ROLE_MEDIC)) {
            $responseData = $user->medic()->patients()->get();
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
    public function indexBySystem(Request $request, $system_id)
    {
        if ($request->user()->systems()->first()->system_id != $system_id) {
            abort(403);
        } else {
            return response()->json(Patient::allFullBySystemByState($system_id, PatientState::STATE_HOSPITALIZED));
        }
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
        // Obtener sistema de guardia
        $guardSystem = System::where('system', '=', System::SYSTEM_GUARD)->first();
        // Chequeo de camas disponibles
        if (!$guardSystem->hasBeds()) {
            $message = ['status' => 'warning', 'message' => 'No hay camas disponibles en guardia'];
        }
        else {
            // Information try
            try {
                // Validación de paciente
                $this->validatePatient($data);
                $this->validatePatientEntry($data);

                // Chequeo de DNI existente
                if (Patient::dniExists($data->dni)) {
                    $message = ['status' => 'warning', 'message' => 'El paciente con ese DNI ya existe en el sistema'];
                }
                else {
                    // Nuevo paciente
                    $patient = new Patient;
                    $store_data = $data;
                    $store_data->patient_state_id = PatientState::where('patient_state', '=', PatientState::STATE_HOSPITALIZED)->first()->patient_state_id;
                    $store_data->system_id = $guardSystem->system_id;
                    $patient = Patient::createPatient($store_data);

                    // Mensaje
                    $message = ['status' => 'success', 'message' => 'Se guardo el paciente y ha sido ingresado a guardia.'];
                }
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
    public function update(Request $request)
    {
        try {
            // Validación
            $this->validatePatient($request);
            // Buscar paciente
            $patient = Patient::find($request->patient_id);
            // Buscar usuario
            $user = $request->user();
            // Chequeo que pueda editar la información del paciente
            if (!$user->canEditPatient($patient)) {
                $message = ['status' => 'warning', 'message' => 'No tienes el permiso para realizar esta acción'];
            } else {
                $patient->updateData($request);
                $message = ['status' => 'success', 'message' => 'Información guardada con éxito.'];
            }

        } catch (\Exception $e) {
            $message = ['status' => 'warning', 'message' => 'Ocurrió un error. Verifica la información ingresada.'];
        }
        
        return response()->json($message, 200);
    }

    /**
     * Ingresar un paciente al hospital que ya estuvo previamente.
     * 
     * @return JSON.
     */
    public function newEntry(Request $request)
    {
        // Obtener sistema de guardia
        $guardSystem = System::where('system', '=', System::SYSTEM_GUARD)->first();
        // Chequeo de camas disponibles
        if (!$guardSystem->hasBeds()) {
            $message = ['status' => 'warning', 'message' => 'No hay camas disponibles en guardia'];
        }
        // Chequeo de DNI existente
        else if (Patient::dniExistsNotSelf($request)) {
            $message = ['status' => 'warning', 'message' => 'El paciente con ese DNI ya existe en el sistema'];
        } else {
            // Information try
            try {
                // Validación de paciente
                $this->validatePatient($request);
                $this->validatePatientEntry($request);

                // Nuevo paciente
                $patient = Patient::find($request->patient_id);
                $store_data = $request;
                $store_data->patient_state_id = PatientState::where('patient_state', '=', PatientState::STATE_HOSPITALIZED)->first()->patient_state_id;
                $store_data->system_id = $guardSystem->system_id;
                $patient->admitPatient($store_data);

                // Mensaje
                $message = ['status' => 'success', 'message' => 'Se guardo el paciente y ha sido ingresado a guardia.'];
            } catch (\Exception $e) {
                $message = ['status' => 'warning', 'message' => 'Ocurrió un error. Verifica la información ingresada.'];
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
        try {
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
        } catch (\Exception $e) {
            $message = ['status' => 'error', 'Ocurrió un error. No ingreses información incorrecta.'];
        }    
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
        // Validación
        $this->validatePatientDni($request);
        // Obtener paciente
        $patient = Patient::where('dni', '=', $request->dni)->first();
        // Si existe el paciente
        if ($patient) {
            // Si está en internación
            if ($patient->hasState(PatientState::STATE_HOSPITALIZED)) {
                $responseData = ['status' => 'warning', 'message' => 'El paciente ya se encuentra en internación.'];
            }
            else if ($patient->hasState(PatientState::STATE_DEATH)) {
                $responseData = ['status' => 'warning', 'message' => 'El paciente ya se declaró en óbito.'];
            }
            else {
                $responseData = ['status' => 'success', 'message' => 'Se encontró el paciente.', 'patient' => $patient];
            }
        }
        else {
            $responseData = ['status' => 'success', 'message' => 'No se encontró el paciente.'];
        }
        return response()->json($responseData);
    }

    /**
     * Obtener un paciente por su dni.
     * 
     * @return JSON.
     */
    public function searchComplete(Request $request)
    {
        // Obtener paciente
        $responseData = Patient::where('dni', '=', $request->input_data)
            ->orWhere('name', '=', $request->input_data)
            ->orWhere('lastname', '=', $request->input_data)
            ->orWhere('name', 'LIKE', "%{$request->input_data}%")
            ->orWhere('lastname', 'LIKE', "%{$request->input_data}%")
            ->get();

        return response()->json(['result' => $responseData]);
    }

    /**
     * Obtener un paciente por su dni.
     * 
     * @return JSON.
     */
    public function getPatientComplete($id)
    {
        // Obtener paciente
        $patient = Patient::find($id);

        $entries = $patient->entries()->get();

        // Obtener hospitalizaciones
        foreach ($entries as $entry) {
            $entry->hospitalizations = $entry->hospitalizations()->get();

            // Obtener evoluciones
            foreach ($entry->hospitalizations as $hospitalization) {
                $hospitalization->system = System::find($hospitalization->system_id)->system;
                $hospitalization->evolutions = $hospitalization->evolutions()->get();

                // Guardar información de edición
                foreach ($hospitalization->evolutions as $evolution) {
                    $evolution->evolution = true;
                    $evolution->editable = false;
                }
            }
        }


        // Response
        return response()->json([
            'patient' => Patient::full($id),
            'entries' => $entries,
        ]);
    }

    /**
     * Retorna los medicos asignados al paciente y los posibles médicos a asignar
     * 
     * @return JSON.
     */
    public function clinicData($patient_id)
    {
        function calculateEditable($evolution, $parameter) {
            // Fecha de la evolución
            $evolutionDate = new Carbon($evolution->created_at);
            // Fecha de evolucion
            $now = Carbon::now('America/Argentina/Buenos_Aires');
            // Diferencia de fechas
            return ($evolutionDate->diff($now)->days <= $parameter);
        }

        // Parámetro a evaluar
        $parameter = Settings::find(1)->editing_days;

        // Obtener paciente
        $patient = Patient::find($patient_id); // Obtener paciente
        // Obtener evoluciones
        $evolutions = $patient->currentEvolutions()->get();
        // Obtener cambios de sistema
        $systemChanges = $patient->systemChanges();
        // Añadir campo evolution
        foreach ($evolutions as $evolution) {
            $evolution->evolution = true;
            $evolution->editable = (calculateEditable($evolution, $parameter));
        }
        foreach ($systemChanges as $systemChange) {
            $systemChange->evolution = false;
        }

        return response()->json([
            'system_changes' => $systemChanges,
            'evolutions' => $evolutions,
        ]);
    }

    /**
     * Declarar egreso de un paciente.
     * 
     * @return JSON.
     */
    public function declareExit(Request $request)
    {
        try {
            $this->validatePatientId($request);
            $patient = Patient::find($request->patient_id);
            $user = User::find($request->user()->user_id);

            if (!$user->canEditPatient($patient)) {
                abort(403);
            } else {
                $patient->declareExit();
                $message = ['status' => 'success', 'message' => 'El paciente ha sido dado de alta del sistema.'];
            }
        } catch (\Exception $e) {
            $message = ['status' => 'warning', 'message' => 'Ocurrió un error. Verifica la información ingresada.'];
        }

        return response()->json($message);
    }

    /**
     * Declarar egreso de un paciente.
     * 
     * @return JSON.
     */
    public function declareDeath(Request $request)
    {
        try {
            $this->validatePatientId($request);
            $patient = Patient::find($request->patient_id);
            $user = User::find($request->user()->user_id);

            if (!$user->canEditPatient($patient)) {
                abort(403);
            } else {
                $patient->declareDeath();
                $message = ['status' => 'success', 'message' => 'El paciente ha sido declarado en óbito.'];
            }
        } catch (\Exception $e) {
            $message = ['status' => 'warning', 'message' => 'Ocurrió un error. Verifica la información ingresada.'];
        }

        return response()->json($message);
    }
}
