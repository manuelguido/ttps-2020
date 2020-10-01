<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalEnsurance extends Model
{
    /**
     * Attributes
     */
    protected $table = 'medical_ensurances';

    protected $primaryKey = 'medical_ensurance_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'medical_ensurance',
    ];

    public $timestamps = false;

    /**
     * Returns the users in the systems
     */
    public function patients()
    {
        return $this->hasMany('App\Patient','medical_ensurance_id', 'medical_ensurance_id');
    }
}
