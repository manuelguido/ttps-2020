<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemChange extends Model
{
    /**
     * Attributes
     */
    protected $table = 'system_changes';

    protected $primaryKey = 'system_change_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id', 'old_system', 'new_system', 'user_id',
    ];

    public $timestamps = true;


    /**
     * Obtener el paciente del cambio de sistema.
     * 
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

    /**
     * Obtener el paciente del cambio de sistema.
     * 
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
