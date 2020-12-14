<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Patient;
use App\Alert;

class RuleSettings extends Model
{
    /**
     * Mensajes de alertas
     */
    const MESSAGE_E1 = 'Evaluar pase a UTI.'; // Alertas 1,2,3
    const MESSAGE_E2 = 'Evaluar alta.'; // Alerta 4
    const MESSAGE_E3 = 'Evaluar oxigenoterapia y prono.'; // Alertas 5,6

    /**
     * Attributes
     */
    protected $table = 'rule_settings';

    protected $primaryKey = 'rule_setting_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activated', 'breathing_rate', 'days_to_evaluate', 'oxigen_saturation', 'oxigen_saturation_down_percentage',
    ];

    public $timestamps = false;

 
    /**
     * Analizar todas las reglas.
     * 
     * @return void.
     */
    public function analizeAllRules($patient_id, $evolution)
    {
        $patient = Patient::find($patient_id); // Paciente
        $medics = $patient->medicsFull(); // Medicos asignados
        $chief = $patient->system()->first()->chief()->first(); // Jefe de sistema del paciente

        // Evaluación de Regla 1
        $rule1Condition = $this->analizeRule1($evolution);
        if ($rule1Condition) {
            // Crear alerta
            $textData = RuleSettings::MESSAGE_E1." (El paciente tiene somnolencia)";
            $this->createAlert($textData, $patient_id, $medics, $chief);
        }

        // Evaluación de Regla 2
        $rule2Condition = $this->analizeRule2($evolution);
        if ($rule2Condition) {
            // Crear alerta
            $textData = RuleSettings::MESSAGE_E1." (Mecánica ventilatoria 'Regular' o 'Mala')";
            $this->createAlert($textData, $patient_id, $medics, $chief);
        }

        // Evaluación de Regla 3
        $rule3Condition = $this->analizeRule3($evolution);
        if ($rule3Condition) {
            // Crear alerta
            $textData = RuleSettings::MESSAGE_E1." (Frecuencia respiratoria mayor a ".$this->breathing_rate.")";
            $this->createAlert($textData, $patient_id, $medics, $chief);
        }

        // Evaluación de Regla 4
        $rule4Condition = $this->analizeRule4($patient, $evolution);
        if ($rule4Condition) {
            // Crear alerta
            $textData = RuleSettings::MESSAGE_E2." (Pasaron al menos ".$this->days_to_evaluate." días desde el inicio de los síntomas)";
            $this->createAlert($textData, $patient_id, $medics, $chief);
        }

        // Evaluación de Regla 5
        $rule5Condition = $this->analizeRule5($evolution);
        if ($rule5Condition) {
            // Crear alerta
            $textData = RuleSettings::MESSAGE_E3." (La saturación de oxígeno es menor a ".$this->oxigen_saturation.")";
            $this->createAlert($textData, $patient_id, $medics, $chief);
        }

        // Evaluación de Regla 6
        if (!$rule5Condition) {
            $rule6Condition = $this->analizeRule6($patient, $evolution);
            // Crear alerta
            if ($rule6Condition) {
                $textData = RuleSettings::MESSAGE_E3." (La saturación de oxígeno bajó al menos un ".$this->oxigen_saturation_down_percentage."%)";
                $this->createAlert($textData, $patient_id, $medics, $chief);
            }
        }
    }

    /**
     * Analizar regla 1
     * Si somnolencia es true: Evaluar pase a UTI.
     * 
     * @return Boolean.
     */
    private function analizeRule1($evolution)
    {
        $ruleCondition = $evolution->drowsiness;

        return $ruleCondition;
    }

    /**
     * Analizar regla 2
     * Si paciente tiene mecánica ventilatoria "Regular" o "Mala": Evaluar pase a UTI.
     * 
     * @return Boolean.
     */
    private function analizeRule2($evolution)
    {
        $mv_regular = VentilatoryMechanic::where('ventilatory_mechanic', '=', VentilatoryMechanic::REGULAR)
            ->first()
            ->ventilatory_mechanic_id;

        $bad_vm = VentilatoryMechanic::where('ventilatory_mechanic', '=', VentilatoryMechanic::BAD)
            ->first()
            ->ventilatory_mechanic_id;

        $evolution_vm = $evolution->ventilatory_mechanic_id;

        $ruleCondition = ($evolution_vm == $mv_regular || $evolution_vm == $bad_vm);

        return $ruleCondition;
    }

    /**
     * Analizar regla 3
     * Frecuencia respiratoria es mayor a (PARÁMETRO) por min: Evaluar pase a UTI.
     * 
     * @return Boolean.
     */
    private function analizeRule3($evolution)
    {
        $ruleCondition = ($evolution->breathing_rate > $this->breathing_rate);

        return $ruleCondition;
    }

    /**
     * Analizar regla 4
     * Pasaron (PARÁMETRO) días desde el inicio de los síntomas: Evaluar alta.
     * 
     * @return Boolean.
     */
    private function analizeRule4($patient, $evolution)
    {
        // Parámetro a evaluar
        $parameter = $this->days_to_evaluate;
        // Fecha de diagnostico
        $initialDate = new Carbon($patient->currentEntry()->date_of_diagnosis);
        // Fecha de la evolución
        $evolutionDate = new Carbon($evolution->created_at);
        // Diferencia de fechas
        $ruleCondition = ($initialDate->diff($evolutionDate)->days >= $parameter);

        return $ruleCondition;
    }

    /**
     * Analizar regla 5:
     * Saturación oxígeno menor a (PARÁMETRO): Evaluar oxigenoterapia y prono.
     * 
     * @return Boolean.
     */
    private function analizeRule5($evolution)
    {
        $ruleCondition = false;
        $currentSaturation = $evolution->oxigen_saturation;

        if ($currentSaturation != null) {
            $ruleCondition = ($evolution->oxigen_saturation < $this->oxigen_saturation);
        }
        
        return $ruleCondition;
    }

    /**
     * Analizar regla 6:
     * La saturación de oxígeno bajó (PARÁMETRO): Evaluar pase a UTI
     * 
     * @return Boolean.
     */
    private function analizeRule6($patient, $evolution)
    {
        $ruleCondition = false;

        $previousEvolution = $patient->previousEvolution();

        if ($previousEvolution <> null) {
            $previousData = $previousEvolution->oxigen_saturation;
            $currentData = $patient->lastEvolution()->oxigen_saturation;
            
            $ruleCondition = (($previousData - $currentData) >= $this->oxigen_saturation_down_percentage);
        }
        return $ruleCondition;
    }

    /**
     * Crear una alerta con la información a todos los médicos asignados y jefe de sistema.
     * 
     * @return Boolean.
     */
    private function createAlert($textData, $patient_id, $medics, $chief)
    {
        // Crear alerta a los médicos.
        foreach ($medics as $medic) {
            Alert::createAlert($patient_id, $medic, $textData);
        }

        Alert::createAlert($patient_id, $chief, $textData);
    }
}
