<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $patient->patient_state_id = 1;
        $patient->system_id = 1;
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
        // Rol try
        if (! $data->user()->hasPermission(Permission::PATIENT_STORE)) {
            $message = ['status' => 'warning', 'message' => 'No tienes el permiso para realizar esta acción'];
            return response()->json($message, 200);
        } else {
            if (Patient::dniExists($data->dni)) {
                $message = ['status' => 'warning', 'message' => 'El paciente con ese DNI ya existe en el sistema'];
                return response()->json($message, 200);
            }
            // Information try
            try {
                // $this->validatePatient();
                $patient = new Patient;

                $store_data = $data;
                $store_data->patient_state_id = PatientState::where('patient_state', '=', PatientState::STATE_HOSPITALIZED)->first()->patient_state_id;
                $store_data->system_id = System::where('system', '=', System::SYSTEM_GUARD)->first()->system_id;
                
                $this->save($patient, $store_data);

                // Returning the view
                $message = ['status' => 'success', 'message' => 'Paciente guardado'];
            } catch (\Exception $e) {
                $message = ['status' => 'warning', 'message' => $e->errorInfo[2]];
            }

            return response()->json($message, 200);
        }
    }
}
