<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientState extends Model
{
    /**
     * Attributes
     */
    protected $table = 'patient_states';

    protected $primaryKey = 'patient_state_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_state',
    ];

    public $timestamps = false;

    /**
     * Retorna los pacientes con este estado
     */
    public function patients()
    {
        return $this->hasMany('App\Patient', 'patient_id', 'system_id');
    }
}
