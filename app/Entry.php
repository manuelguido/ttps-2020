<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Entry extends Model
{
    /**
     * Attributes
     */
    protected $table = 'entries';

    protected $primaryKey = 'entry_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id', 'date', 'time', 'actual_disease', 'date_of_symptoms', 'date_of_diagnosis', 'date_of_admission', 'date_of_death', 'date_of_exit',
    ];

    public $timestamps = false;

    /**
     * Obtener el paciente al cual pertenece esta entrada al hospital.
     * 
     * @return App\Patient.
     */
    public function entry()
    {
        return $this->belongsTo('App\Patient');
    }

    /**
     * Obtener las hospitalizaciones de la entrada al hospital.
     * 
     * @return App\Hospitalization Collection.
     */
    public function hospitalizations()
    {
        return Hospitalization::where('entry_id', '=', $this->entry_id);
    }

    /**
     * Añadir una hospitalización a la entrada al hospital.
     * 
     * @return App\Hospitalization.
     */
    public function addHospitalization($system_id, $previous_system_id = NULL)
    {
        $hospitalization = new Hospitalization;
        $hospitalization->created_at = Carbon::now('America/Argentina/Buenos_Aires');
        $hospitalization->updated_at = Carbon::now('America/Argentina/Buenos_Aires');
        $hospitalization->entry_id = $this->entry_id;
        $hospitalization->system_id = $system_id;
        $hospitalization->previous_system_id = $previous_system_id;
        $hospitalization->save();
        return $hospitalization;
    }
}
