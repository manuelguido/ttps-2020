<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evolution;
use App\Patient;

class EvolutionController extends Controller
{
        /**
     * Validación de datos de paciente
     */
    private function validateEvolution($data)
    {
        $this->validate($data, [
            'patient_id' => 'required|integer|min:1',
            'vital_signs' => 'required|string',
            'respiratory_system' => 'required|string',
            'other_sintoms' => 'sometimes|string',
            'studies_of_the_day' => 'required|string',
            'current_treatments' => 'required|string',
            'observations' => 'sometimes|string',
        ]);
    }

    public function store(Request $request)
    {
        // try {
            // Validación de la evolucion
            $this->validateEvolution($request);

            // $patient = Patient::find($request->patient_id);

            $evolution = Evolution::createEvolution($request);

            $message = ['status' => 'primary', 'message' => 'Guardado'];
        // }
        // catch (\Exception $e)
        // {
            // $message = ['status' => 'warning', 'message' => $e];
        // }

        // return response()->json($message, 200);
    }
}
