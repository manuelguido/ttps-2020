<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospitalization extends Model
{
    /**
     * Attributes
     */
    protected $table = 'hospitalizations';

    protected $primaryKey = 'hospitalization_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entry_id', 'system_id', 'actual_disease', 'date_of_diagnosis', 'date_of_admission', 'date_of_death', 'date_of_exit',
    ];

    public $timestamps = false;

    /**
     * Obtener la entrada al hospital a la que pertenece la hospitalización.
     * 
     * @return App\Entry.
     */
    public function entry()
    {
        return $this->belongsTo('App\Entry');
    }

    /**
     * Obtener las evoluciones de la hospitalización.
     * 
     * @return App\Evolution Collection.
     */
    public function evolutions()
    {
        return $this->hasMany('App\Evolution');
    }
}
