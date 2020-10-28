<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemChange;
use App\PatientState;
use App\Permission;
use App\Patient;
use App\System;
use App\Role;

class PatientController extends Controller
{
    /**
     * Validación de datos de paciente
     */
    private function validatePatient()
    {
        return request()->validate([
            'name' => 'required|string|max:255',
            'desc' => 'sometimes|string',
            'image' => 'required|file|image|mimes:jpeg,png,gif,jpg,webp',
            'icon' => 'required|file|image|mimes:jpeg,png,gif,jpg,webp',
        ]);
    }

    /**
     * Retorna los pacientes
     */
    public function index()
    {
        return response()->json(Patient::allFull());
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
     * Almacena un paciente
     */
    public function store(Request $data)
    {
        $guard = System::where('system', '=', System::SYSTEM_GUARD)->first();

        // Chequeo que tenga permiso
        if (! $data->user()->hasPermission(Permission::PATIENT_STORE))
        {
            $message = ['status' => 'warning', 'message' => 'No tienes el permiso para realizar esta acción'];
        }
        // Chqueo que haya camas en la guardia
        else if (! $guard->hasBeds())
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
            try {
                // Validación de paciente
                // $this->validatePatient();
                
                // Nuevo paciente
                $patient = new Patient;

                // // Almacenamiento de información
                $store_data = $data;
                $store_data->patient_state_id = PatientState::where('patient_state', '=', PatientState::STATE_HOSPITALIZED)->first()->patient_state_id;
                $store_data->system_id = System::where('system', '=', System::SYSTEM_GUARD)->first()->system_id;
                
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
            'medics' => $patient->medics(),
            'posible_medics' => $patient->posibleMedics(),
        ]);
    }


    /**
     * Retorna los medicos asignados al paciente y los posibles médicos a asignar
     */
    public function addMedic(Request $data)
    {
        $patient = Patient::find($data->patient_id); 
        if ($patient->hasMedic($data->user_id))
        {
            $message = ['status' => 'warning', 'message' => 'El paciente ya tiene asignado al médico.'];
        }
        else
        {
            $patient->addMedic($data->user_id);

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
        if (! $patient->hasMedic($data->user_id))
        {
            $message = ['status' => 'warning', 'message' => 'El paciente no tiene asignado al médico.'];
        }
        else
        {
            $patient->removeMedic($data->user_id);

            // Returning the view
            $message = ['status' => 'success', 'message' => 'El médico ya no está asignado al paciente.'];
        }
        return response()->json($message, 200);
    }



        /**
     * Retorna los medicos asignados al paciente y los posibles médicos a asignar
     */
    public function hospitalizations($patient_id)
    {
        return response()->json(SystemChange::where('patient_id', '=', $patient_id)->orderBy('created_at', 'DESC')->get());
    }
}
