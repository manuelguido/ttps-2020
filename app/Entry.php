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
        'patient_id', 'date', 'time',
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
        return $this->hasMany('App\Hospitalization');
    }
}
