<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Role;

class PatientController extends Controller
{

    /**
     * Columnas para la tabla completa
     */
    private function column_fields ()
    {
        return [
            ['label' => 'Nombre', 'field' => 'name', 'sort' => 'asc'],
            ['label' => 'Apellido', 'field' => 'lastname', 'sort' => 'asc'],
            ['label' => 'Dirección', 'field' => 'address', 'sort' => 'asc'],
            ['label' => 'Teléfono', 'field' => 'phone', 'sort' => 'asc'],   
        ];
    }

    /**
     * Retorna los pacientes en forma de tabla con json para mostrar de forma completa en frontend 
     */
    public function index()
    {
        // $data['columns'] = $this->column_fields();
        // $data['rows'] = Patient::all_with_medical_ensurance();
        // return response()->json($data);
        return response()->json(Patient::all_with_medical_ensurance());
    }

    /**
     * Retorna solo los pacientes
     */
    public function index_by_system()
    {
        return response()->json(Patient::all());
    }

    /**
     * Almacena un paciente
     */
    public function store(Request $data)
    {
        // Rol try
        if (!app('App\Http\Controllers\RoleController')->has_role(ROLE::ROLE_ADMIN) AND 1 > 2) {
            $message = ['status' => 'warning', 'message' => 'No tienes el permiso para realizar esta acción'];
            return response()->json($message, 200);
        } else {
            // Information try
            try {
                $patient = new Patient;
                $patient->name = $data->name;
                $patient->lastname = $data->lastname;
                $patient->dni = $data->dni;
                $patient->address = $data->address;
                $patient->phone = $data->phone;
                $patient->birth_date = $data->birth_date;
                $patient->patient_state_id = 1;
                $patient->system_id = 1;
                $patient->personal_background = $data->personal_background;
                $patient->medical_ensurance_id = $data->medical_ensurance_id;
                $patient->save();
                
                // Returning the view
                $message = ['status' => 'success', 'message' => 'Paciente guardado'];
            } catch (\Exception $e) {
                $message = ['status' => 'warning', 'message' => $e];
            }

            return response()->json($message, 200);
        }
    }
}
