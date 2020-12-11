<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
        'patient_id', 'user_id', 'seen', 'description',
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
     * @return App\Medic.
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

    public static function createAlert($patient_id, $user, $textData = "")
    {
        $alert = new Alert;
        $alert->patient_id = $patient_id;
        $alert->user_id = $user->user_id;
        $alert->description = $textData;
        $alert->seen = false;
        $alert->save();
    }
}