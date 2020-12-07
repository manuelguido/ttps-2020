<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evolution;
use App\Patient;

class EvolutionController extends Controller
{
    /**
     * Validación de id del paciente.
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
     * Validación de datos básicos de evolución.
     * 
     * @return void.
     */
    private function validateEvolution($data)
    {
        $this->validate($data, [
            'evolution.temperature' => 'required|min:0|numeric',
            'evolution.heart_rate' => 'required|min:0|integer',
            'evolution.breathing_rate' => 'sometimes|min:0|integer',
            'evolution.systolic_ta' => 'required|min:0|integer',
            'evolution.diastolic_ta' => 'required|min:0|integer',
        ]);
    }

    /**
     * Validación de datos del sistema respiratorio.
     * 
     * @return void.
     */
    private function validateRespiratorySystem($data)
    {
        $this->validate($data, [
            'respiratory.ventilatory_mechanic_id' => 'sometimes|integer|nullable',
            'respiratory.requires_oxigen' => 'sometimes|boolean',
            'respiratory.required_oxigen_type_id' => 'sometimes|integer|min:0|nullable',
            'respiratory.required_oxigen_value' => 'sometimes|integer|min:0|nullable',
            'respiratory.pafi' => 'sometimes|boolean',
            'respiratory.pafi_value' => 'sometimes|integer|min:0|nullable',
            'respiratory.prone' => 'sometimes|boolean',
            'respiratory.cough' => 'sometimes|boolean',
            'respiratory.dyspnoea_id' => 'sometimes|integer|min:0|nullable',
            'respiratory.respiratory_irregularities' => 'sometimes|boolean',
        ]);
    }

    /**
     * Validación de otros síntomas del paciente.
     * 
     * @return void.
     */
    private function validateOtherSymptoms($data)
    {
        $this->validate($data, [
            'otherSymptoms.drowsiness' => 'sometimes|boolean',
            'otherSymptoms.drowsiness' => 'sometimes|boolean',
            'otherSymptoms.drowsiness' => 'sometimes|boolean',
        ]);
    }

    /**
     * Validación de estudios del día que se efectuaron al paciente.
     * 
     * @return void.
     */
    private function validateStudies($data)
    {
        $this->validate($data, [
            'studies.rxtx' => 'sometimes|boolean',
            'studies.tac' => 'sometimes|boolean',
            'studies.ecg' => 'sometimes|boolean',
            'studies.pcr' => 'sometimes|boolean',
            'studies.laboratory' => 'sometimes|boolean',
        ]);
    }

    /**
     * Validación de tratamientos actuales del paciente.
     * 
     * @return void.
     */
    private function validateActualTreatments($data)
    {
        $this->validate($data, [
            'actualTreatments.feeding_type_id' => 'sometimes|integer|nullable',
            'actualTreatments.feeding_note' => 'sometimes|string|nullable',
            'actualTreatments.drug' => 'sometimes|string|nullable',
            'actualTreatments.drug_dosis' => 'sometimes|string|nullable',
            'actualTreatments.dosis_day_number' => 'sometimes|integer|min:0|nullable',
            'actualTreatments.thromboprophylaxis' => 'sometimes|boolean|nullable',
            'actualTreatments.thromboprophylaxis_data' => 'sometimes|string|nullable',
            'actualTreatments.dexamethasone' => 'sometimes|boolean|nullable',
            'actualTreatments.dexamethasone_data' => 'sometimes|string|nullable',
            'actualTreatments.gastric_protection' => 'sometimes|boolean|nullable',
            'actualTreatments.gastric_protection_data' => 'sometimes|string|nullable',
            'actualTreatments.dialysis' => 'sometimes|boolean|nullable',
            'actualTreatments.dialysis_data' => 'sometimes|string|nullable',
            'actualTreatments.research_study' => 'sometimes|boolean|nullable',
            'actualTreatments.research_study_data' => 'sometimes|string|nullable',
        ]);
    }

    /**
     * Validación de datos de observación del paciente.
     * 
     * @return void.
     */
    private function validateObservations($data)
    {
        $this->validate($data, [
            'observations.observations' => 'sometimes|string|nullable',
        ]);
    }

    /**
     * Almacenar una nueva evolución.
     * 
     * @return JSON.
     */
    public function store(Request $request)
    {
        // try {
            // Validación de la evolucion
            $this->validatePatientId($request);
            $this->validateEvolution($request);
            $this->validateRespiratorySystem($request);
            $this->validateOtherSymptoms($request);
            $this->validateStudies($request);
            $this->validateActualTreatments($request);
            $this->validateObservations($request);

            $hospitalization_id = Patient::find($request->patient_id)->currentHospitalization()->hospitalization_id;
            // $user_id = $request->user()->user_id; // Id del usuario que crea la evolución

            // $evolution = Evolution::createEvolution($request, $user_id);

            $message = ['status' => 'success', 'message' => 'Evolución guardada con exito.'.$hospitalization_id];
        // }
        // catch (\Exception $e)
        // {
            // $message = ['status' => 'warning', 'message' => $e];
        // }

        return response()->json($message, 200);
    }
}
