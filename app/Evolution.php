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
      
        'ventilatory_mechanic_id', 'requires_oxigen', 'required_oxigen_type_id', 'required_oxigen_value',
        'pafi', 'pafi_value', 'prone', 'cough', 'dyspnoea_id', 'respiratory_irregularities',

        'drowsiness', 'anosmia', 'dysgeucia',

        'rxtx', 'tac', 'ecg', 'pcr', 'laboratory',
      
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
        $this->temperature = $data->temperature;
        $this->heart_rate = $data->heart_rate;
        $this->breathing_rate = $data->breathing_rate;
        $this->systolic_ta = $data->systolic_ta;
        $this->diastolic_ta = $data->diastolic_ta;
      
        $this->ventilatory_mechanic_id = $data->ventilatory_mechanic_id;
        $this->requires_oxigen = $data->requires_oxigen;
        $this->required_oxigen_type_id = $data->required_oxigen_type_id;
        $this->required_oxigen_value = $data->required_oxigen_value;
        $this->pafi = $data->pafi;
        $this->pafi_value = $data->pafi_value;
        $this->prone = $data->prone;
        $this->cough = $data->cough;
        $this->dyspnoea_id = $data->dyspnoea_id;
        $this->respiratory_irregularities = $data->respiratory_irregularities;

        $this->drowsiness = $data->drowsiness;
        $this->anosmia = $data->anosmia;
        $this->dysgeucia = $data->dysgeucia;

        $this->rxtx = $data->rxtx;
        $this->tac = $data->tac;
        $this->ecg = $data->ecg;
        $this->pcr = $data->pcr;
        $this->laboratory = $data->laboratory;
      
        $this->feeding_type_id = $data->feeding_type_id;
        $this->feeding_note = $data->feeding_note;
        $this->drug = $data->drug;
        $this->drug_dosis = $data->drug_dosis;
        $this->dosis_day_number = $data->dosis_day_number;
        $this->thromboprophylaxis = $data->thromboprophylaxis;
        $this->thromboprophylaxis_data = $data->thromboprophylaxis_data;
        $this->dexamethasone = $data->dexamethasone;
        $this->dexamethasone_data = $data->dexamethasone_data;
        $this->gastric_protection = $data->gastric_protection;
        $this->gastric_protection_data = $data->gastric_protection_data;
        $this->dialysis = $data->dialysis;
        $this->dialysis_data = $data->dialysis_data;
        $this->research_study = $data->research_study;
        $this->research_study_data = $data->research_study_data;

        $this->observations = $data->observations;

        $this->save();
    }
}
