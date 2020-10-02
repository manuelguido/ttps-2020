<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /**
     * Attributes
     */
    protected $table = 'patients';

    protected $primaryKey = 'patient_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'address', 'phone', 'birth_date', 'personal_background', 'medical_ensurance_id',
    ];

    public $timestamps = false;

    /**
     * Retorna el usuario correspondiente al médico
     */
    public static function all_with_medical_ensurance()
    {
        return Patient::join('medical_ensurances', 'medical_ensurances.medical_ensurance_id', '=', 'patients.medical_ensurance_id')->get();
    }

    /**
     * Retorna la obra social del paciente
     */
    public function medicalEnsurance()
    {
        return $this->belongsTo('App\MedicalEnsurance');
    }
}
