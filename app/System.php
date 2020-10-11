<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    const SYSTEM_GUARD = 'Guardia';
    const SYSTEM_COVID_FLOOR = 'Piso Covid';
    const SYSTEM_UTI = 'UTI';
    const SYSTEM_HOTEL = 'Hotel';
    const SYSTEM_HOME = 'Domicilio';

    /**
     * Attributes
     */
    protected $table = 'systems';

    protected $primaryKey = 'system_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'system',
    ];

    public $timestamps = false;

    /**
     * Retorna los usuarios del sistema
     */
    public function users()
    {
        return $this->belongsToMany('App\User','role_user', 'role_id', 'user_id');
    }

    /**
     * Retorna los pacientes del sistema
     */
    public function patients()
    {
        return $this->hasMany('App\Patient', 'patient_id', 'system_id');
    }
}
