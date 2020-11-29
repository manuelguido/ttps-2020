<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        // return $this->hasMany('App\Hospitalization');
    }

    /**
     * Añadir una hospitalización a la entrada al hospital.
     * 
     * @return App\Hospitalization.
     */
    public function addHospitalization($system_id)
    {
        $hospitalization = new Hospitalization;
        $hospitalization->entry_id = $this->entry_id;
        $hospitalization->system_id = $system_id;
        $hospitalization->actual_disease = 'Actual Disease';
        $hospitalization->date_of_diagnosis = Carbon::now('America/Argentina/Buenos_Aires');
        $hospitalization->date_of_death = NULL;
        $hospitalization->date_of_exit = NULL;
        $hospitalization->save();
        return $hospitalization;
    }
}
