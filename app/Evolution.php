<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
