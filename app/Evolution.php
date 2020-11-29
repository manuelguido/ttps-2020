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
        'hospitalization_id', 'date', 'vital_signs', 'respiratory_system', 'other_sintoms', 'studies_of_the_day', 'current_treatments', 'observations',
    ];

    public $timestamps = false;

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
     * Crear evolucion.
     * 
     * @return App\Evolution.
     */
    public static function createEvolution($data)
    {
        $evolution = new Evolution;
        $evolution->hospitalization_id = Patient::find($data->patient_id); //->currentHospitalization()->hospitalization_id;
        $evolution->date = Carbon::now('America/Argentina/Buenos_Aires');
        $evolution->vital_signs = $data->vital_signs;
        $evolution->respiratory_system = $data->respiratory_system;
        $evolution->other_sintoms = $data->other_sintoms;
        $evolution->studies_of_the_day = $data->studies_of_the_day;
        $evolution->current_treatments = $data->current_treatments;
        $evolution->observations = $data->observations;
        $evolution->save();
        return $evolution;
    }
}
