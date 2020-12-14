<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Evolution extends Model
{
    /**
     * Attributes
     */
    protected $table = 'evolutions';    

    protected $primaryKey = 'evolution_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hospitalization_id', 'user_id',
        'temperature', 'heart_rate', 'breathing_rate', 'systolic_ta', 'diastolic_ta',
      
        'ventilatory_mechanic_id', 'requires_oxigen', 'oxigen_requirement_type_id', 'required_oxigen_value', 'oxigen_saturation',
        'pafi', 'pafi_value', 'prone', 'cough', 'dyspnoea', 'respiratory_irregularities',

        'drowsiness', 'anosmia', 'dysgeucia',

        'rxtx', 'rxtx_type', 'rxtx_text',
        'tac', 'tac_type', 'tac_text',
        'ecg', 'ecg_type', 'ecg_text',
        'pcr', 'pcr_type', 'pcr_text',
        'laboratory',
      
        'feeding_type_id', 'feeding_note', 'drug', 'drug_dosis', 'dosis_day_number',
        'thromboprophylaxis', 'thromboprophylaxis_data',
        'dexamethasone', 'dexamethasone_data',
        'gastric_protection', 'gastric_protection_data',
        'dialysis', 'dialysis_data',
        'research_study', 'research_study_data',

        'observations',
    ];

    public $timestamps = true;

    /**
     * Obtener la hospitalización a la que pertenece la evolución.
     * 
     * @return App\Hospitalization.
     */
    public function hospitalization()
    {
        return $this->belongsTo('App\Hospitalization');
    }

    /**
     * Obtener el usuario que creó la evolución.
     * 
     * @return App\User.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Crear evolucion.
     * 
     * @return App\Evolution.
     */
    public static function createEvolution($data, $user_id, $hospitalization_id)
    {
        $evolution = new Evolution;
        $evolution->created_at = Carbon::now('America/Argentina/Buenos_Aires');
        $evolution->hospitalization_id = $hospitalization_id;
        $evolution->user_id = $user_id;
        $evolution->saveEvolutionData($data);
        return $evolution;
    }

    /**
     * Crear evolucion.
     * 
     * @return App\Evolution.
     */
    public function updateEvolution($data)
    {
        $evolution->saveEvolutionData($data);
        return $evolution;
    }


    /**
     * Guarda la información de una evolución.
     * 
     * @return void.
     */
    private function saveEvolutionData($data)
    {
        // Step 1
        $this->temperature = $data->evolution['temperature'];
        $this->heart_rate = $data->evolution['heart_rate'];
        $this->breathing_rate = $data->evolution['breathing_rate'];
        $this->systolic_ta = $data->evolution['systolic_ta'];
        $this->diastolic_ta = $data->evolution['diastolic_ta'];
      
        // Step 2
        $this->ventilatory_mechanic_id = $data->respiratory['ventilatory_mechanic_id'];
        $this->requires_oxigen = $data->respiratory['requires_oxigen'];
        $this->oxigen_requirement_type_id = $data->respiratory['oxigen_requirement_type_id'];
        $this->oxigen_requirement_value = $data->respiratory['oxigen_requirement_value'];
        $this->oxigen_saturation = $data->respiratory['oxigen_saturation'];
        $this->pafi = $data->respiratory['pafi'];
        $this->pafi_value = $data->respiratory['pafi_value'];
        $this->prone = $data->respiratory['prone'];
        $this->cough = $data->respiratory['cough'];
        $this->dyspnoea = $data->respiratory['dyspnoea'];
        $this->respiratory_irregularities = $data->respiratory['respiratory_irregularities'];

        // Step 3
        $this->drowsiness = $data->otherSymptoms['drowsiness'];
        $this->anosmia = $data->otherSymptoms['anosmia'];
        $this->dysgeucia = $data->otherSymptoms['dysgeucia'];

        // Step 4
        $this->rxtx = $data->studies['rxtx'];
        if($data->studies['rxtx']) { 
            $this->rxtx_type = $data->studies['rxtx_type'];
            if($data->studies['rxtx_type'] == 2) {
                $this->rxtx_text = $data->studies['rxtx_text'];
            }
        }
        $this->tac = $data->studies['tac'];
        if($data->studies['tac']) { 
            $this->tac_type = $data->studies['tac_type'];
            if($data->studies['tac_type'] == 2) {
                $this->tac_text = $data->studies['tac_text'];
            }
        }
        $this->ecg = $data->studies['ecg'];
        if($data->studies['ecg']) { 
            $this->ecg_type = $data->studies['ecg_type'];
            if($data->studies['ecg_type'] == 2) {
                $this->ecg_text = $data->studies['ecg_text'];
            }
        }
        $this->pcr = $data->studies['pcr'];
        if($data->studies['pcr']) { 
            $this->pcr_type = $data->studies['pcr_type'];
            if($data->studies['pcr_type'] == 2) {
                $this->pcr_text = $data->studies['pcr_text'];
            }
        }
        $this->laboratory = $data->studies['laboratory'];
      
        // Step 5
        $this->feeding_type_id = $data->actualTreatments['feeding_type_id'];
        $this->feeding_note = $data->actualTreatments['feeding_note'];
        $this->drug = $data->actualTreatments['drug'];
        $this->drug_dosis = $data->actualTreatments['drug_dosis'];
        $this->dosis_day_number = $data->actualTreatments['dosis_day_number'];

        $this->thromboprophylaxis = $data->actualTreatments['thromboprophylaxis'];
        if ($data->actualTreatments['thromboprophylaxis']) {
            $this->thromboprophylaxis_data = $data->actualTreatments['thromboprophylaxis_data'];
        }
        $this->dexamethasone = $data->actualTreatments['dexamethasone'];
        if ($data->actualTreatments['dexamethasone']) {
            $this->dexamethasone_data = $data->actualTreatments['dexamethasone_data'];
        }

        $this->gastric_protection = $data->actualTreatments['gastric_protection'];
        if ($data->actualTreatments['gastric_protection']) {
            $this->gastric_protection_data = $data->actualTreatments['gastric_protection_data'];
        }

        $this->dialysis = $data->actualTreatments['dialysis'];
        if ($data->actualTreatments['dialysis']) {
            $this->dialysis_data = $data->actualTreatments['dialysis_data'];
        }

        $this->research_study = $data->actualTreatments['research_study'];
        if ($data->actualTreatments['research_study']) {
            $this->research_study_data = $data->actualTreatments['research_study_data'];
        }

        // Step 6
        $this->observations = $data->observations['observations'];

        $this->save();
    }
}
