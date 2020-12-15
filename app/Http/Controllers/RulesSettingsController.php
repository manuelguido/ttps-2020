<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RuleSettings;

class RulesSettingsController extends Controller
{
    /**
     * Validación de información de parametros.
     * 
     * @return void.
     */
    private function validateRules($data)
    {
        $this->validate($data, [
            'activated' => 'required|boolean',
            'breathing_rate' => 'required|integer|min:0',
            'days_to_evaluate' => 'required|integer|min:0',
            'oxigen_saturation' => 'required|integer|min:0|max:100',
            'oxigen_saturation_down_percentage' => 'required|integer|min:0|max:100',
        ]);
    }

    /**
     * Actualizar parametros de alertas.
     * 
     * @return JSON.
     */
    public function show()
    {
        return response()->json(RuleSettings::find(1));
    }

    /**
     * Actualizar parametros de alertas.
     * 
     * @return JSON.
     */
    public function update(Request $request)
    {
        try {
            // Validación de información
            $this->validateRules($request);

            RuleSettings::find(1)->updateData($request);
    
            $message = ['status' => 'success', 'message' => 'Actualizaste los parametros de reglas.'];
        } catch (\Exception $e) {
            $message = ['status' => 'error', 'message' => 'Ocurrió un error. No ingreses información erronea.'];
        }
        
        return response()->json($message, 200);
    }
}
