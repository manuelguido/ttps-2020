<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;

class SettingsController extends Controller
{
/**
     * Validación de información de parametros.
     * 
     * @return void.
     */
    private function validateData($data)
    {
        $this->validate($data, [
            'editing_days' => 'required|integer|min:0',
        ]);
    }

    /**
     * Actualizar parametros de alertas.
     * 
     * @return JSON.
     */
    public function show()
    {
        return response()->json(Settings::find(1));
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
            $this->validateData($request);

            Settings::find(1)->updateData($request);
    
            $message = ['status' => 'success', 'message' => 'Actualizaste la configuración.'];
        } catch (\Exception $e) {
            $message = ['status' => 'error', 'message' => 'Ocurrió un error. No ingreses información erronea.'];
        }
        
        return response()->json($message, 200);
    }
}
