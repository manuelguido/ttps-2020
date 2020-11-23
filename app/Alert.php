<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    /**
     * Attributes
     */
    protected $table = 'alerts';

    protected $primaryKey = 'alert_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id', 'user_id', 'user_id', 'seen',
    ];

    public $timestamps = true;

    /**
     * Obtener el usuario de la notificación.
     * 
     * @return App\User.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Obtener el paciente de la notificación.
     * 
     * @return App\Patient.
     */
    public function medics()
    {
        return $this->belongsTo('App\Patient');
    }

    /**
     * Obtener el sistema de la notificación.
     * 
     * @return App\System.
     */
    public function system()
    {
        return $this->belongsTo('App\System');
    }
}