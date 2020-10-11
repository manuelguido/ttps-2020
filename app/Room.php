<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /**
     * Attributes
     */
    protected $table = 'rooms';

    protected $primaryKey = 'room_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'room', 'system_id',
    ];

    public $timestamps = false;

    /**
     * Retorna el sistema de la habitación
     */
    public function system()
    {
        return $this->belongsTo('App\System');
    }

    /**
     * Retorna las camas de la habitación
     */
    public function beds()
    {
        return $this->hasMany('App\Bed');
    }
}
