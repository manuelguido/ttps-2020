<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OxigenRequirementType;
use App\VentilatoryMechanic;
use App\RuleSettings;
use App\FeedingType;
use App\Evolution;
use App\Patient;

class EvolutionController extends Controller
{
    /**
     * Validación de id de la evolución.
     * 
     * @return void.
     */
    private function validateEvolutionId($data)
    {
        $this->validate($data, [
            'evolution_id' => 'required|integer|min:1',
        ]);
    }

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
            'respiratory.ventilatory_mechanic_id' => 'integer|nullable',
            'respiratory.requires_oxigen' => 'boolean',
            'respiratory.oxigen_requirement_type_id' => 'integer|min:0|nullable',
            'respiratory.oxigen_requirement_value' => 'integer|min:0|nullable',
            'respiratori.oxigen_saturation' => 'integer|min:0|nullable',
            'respiratory.pafi' => 'boolean',
            'respiratory.pafi_value' => 'integer|min:0|nullable',
            'respiratory.prone' => 'boolean',
            'respiratory.cough' => 'boolean',
            'respiratory.dyspnoea' => 'integer|min:0|nullable',
            'respiratory.respiratory_irregularities' => 'boolean',
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
            'otherSymptoms.drowsiness' => 'boolean',
            'otherSymptoms.drowsiness' => 'boolean',
            'otherSymptoms.drowsiness' => 'boolean',
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
            'studies.rxtx' => 'boolean|nullable',
            'studies.rxtx_type' => 'integer|min:1|nullable',
            'studies.rxtx_text' => 'string|nullable',
            'studies.tac' => 'boolean|nullable',
            'studies.tac_type' => 'integer|min:1|nullable',
            'studies.tac_text' => 'string|nullable',
            'studies.ecg' => 'boolean|nullable',
            'studies.ecg_type' => 'integer|min:1|nullable',
            'studies.ecg_text' => 'string|nullable',
            'studies.pcr' => 'boolean',
            'studies.pcr_type' => 'integer|min:1|nullable',
            'studies.pcr_text' => 'string|nullable',
            'studies.laboratory' => 'boolean|nullable',
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
            'actualTreatments.feeding_type_id' => 'integer|nullable',
            'actualTreatments.feeding_note' => 'string|nullable',
            'actualTreatments.drug' => 'string|nullable',
            'actualTreatments.drug_dosis' => 'string|nullable',
            'actualTreatments.dosis_day_number' => 'integer|min:0|nullable',
            'actualTreatments.thromboprophylaxis' => 'boolean|nullable',
            'actualTreatments.thromboprophylaxis_data' => 'string|nullable',
            'actualTreatments.dexamethasone' => 'boolean|nullable',
            'actualTreatments.dexamethasone_data' => 'string|nullable',
            'actualTreatments.gastric_protection' => 'boolean|nullable',
            'actualTreatments.gastric_protection_data' => 'string|nullable',
            'actualTreatments.dialysis' => 'boolean|nullable',
            'actualTreatments.dialysis_data' => 'string|nullable',
            'actualTreatments.research_study' => 'boolean|nullable',
            'actualTreatments.research_study_data' => 'string|nullable',
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
    public function show(Request $request)
    {
        // Validación de la evolucion
        $this->validateEvolutionId($request);

        // Crear evolución
        $evolution = Evolution::find($request->evolution_id);

        return response()->json([
            'evolution' => $evolution->evolutionData(),
            'respiratory' => $evolution->respiratoryData(),
            'otherSymptoms' => $evolution->otherSymptomsData(),
            'studies' => $evolution->studiesData(),
            'actualTreatments' => $evolution->actualTreatmentsData(),
            'observations' => $evolution->observationsData(),
        ]);
    }

    /**
     * Almacenar una nueva evolución.
     * 
     * @return JSON.
     */
    public function store(Request $request)
    {
        try {
            // Validación de la evolucion
            $this->validatePatientId($request);
            $this->validateEvolution($request);
            $this->validateRespiratorySystem($request);
            $this->validateOtherSymptoms($request);
            $this->validateStudies($request);
            $this->validateActualTreatments($request);
            $this->validateObservations($request);

            // Id de hospitalización
            $hospitalization_id = Patient::find($request->patient_id)->currentHospitalization()->hospitalization_id;
            // Id del usuario que crea la evolución
            $user_id = $request->user()->user_id;

            // Crear evolución
            $evolution = Evolution::createEvolution($request, $user_id, $hospitalization_id);

            // Chequeo de reglas
            $ruleSettings = RuleSettings::find(1);
            $ruleSettings->analizeAllRules($request->patient_id, $evolution);

            $message = ['status' => 'success', 'message' => 'Evolución guardada con exito.'];
        }
        catch (\Exception $e)
        {
            $message = ['status' => 'warning', 'message' => 'No ingreses información inválida.'];
        }

        return response()->json($message, 200);
    }

    /**
     * Almacenar una nueva evolución.
     * 
     * @return JSON.
     */
    public function update(Request $request)
    {
        // try {
            // Validación de la evolucion
            $this->validateEvolutionId($request);
            $this->validateEvolution($request);
            $this->validateRespiratorySystem($request);
            $this->validateOtherSymptoms($request);
            $this->validateStudies($request);
            $this->validateActualTreatments($request);
            $this->validateObservations($request);

            // Actualizar
            $evolution = Evolution::find($request->evolution_id);
            $patient = $evolution->patient();
            $evolution->updateEvolution($request);

            // Chequeo de reglas
            $ruleSettings = RuleSettings::find(1);
            $ruleSettings->analizeAllRules($patient->patient_id, $evolution);

            $message = ['status' => 'success', 'message' => 'Evolución guardada con exito.'];
        // }
        // catch (\Exception $e)
        // {
            // $message = ['status' => 'warning', 'message' => 'No ingreses información inválida.'];
        // }

        return response()->json($message, 200);
    }

    /**
     * Información para el formulario.
     * 
     * @return JSON.
     */
    public function formData()
    {
        return response()->json([
            'oxigen_requirement_types' => OxigenRequirementType::all(),
            'ventilatory_mechanics' => VentilatoryMechanic::all(),
            'feeding_types' => FeedingType::all(),
        ]);
    }
}
