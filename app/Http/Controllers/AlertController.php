<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alert;

class AlertController extends Controller
{
    /**
     * Validación de dni de paciente
     * 
     * @return void.
     */
    private function validateAlertId($data)
    {
        $this->validate($data, [
            'alert_id' => 'required|integer|min:1',
        ]);
    }

    /**
     * Obtener todas las alertas del usuario.
     * 
     * @return JSON.
     */
    public function index(Request $data)
    {
        return response()->json($data->user()->alertsFull()->get());
    }

    /**
     * Obtener todas las alertas del usuario ya leídas.
     * 
     * @return JSON.
     */
    public function readIndex(Request $data)
    {
        return response()->json($data->user()->alertsBySeen(true)->get());
    }

    /**
     * Obtener todas las alertas del usuario sin leer.
     * 
     * @return JSON.
     */
    public function unreadIndex(Request $data)
    {
        return response()->json($data->user()->alertsBySeen(false)->get());
    }

    /**
     * Obtener la cantidad de alertas sin leer.
     * 
     * @return JSON.
     */
    public function unreadCount(Request $data)
    {
        return response()->json(['count' => $data->user()->alertsBySeen(false)->count()]);
    }

    /**
     * Obtener todas las alertas del usuario.
     * 
     * @return JSON.
     */
    public function read(Request $data)
    {
        // Validar información
        $this->validateAlertId($data);

        // Buscar alerta
        $alert = Alert::find($data->alert_id);

        // Ver que la alerta sea del usuario 
        if($alert->user_id != $data->user()->user_id) {
            $message = ['status' => 'danger', 'message' => 'Ingresaste información no válida.'];
            return response()->json($message); 
        } else {
            $alert->seen = true;
            $alert->save();
            $message = ['status' => 'success', 'message' => 'Marcaste la alerta como leída.'];
            return response()->json($message);
        }
    }
}
