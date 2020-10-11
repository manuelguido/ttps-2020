<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    /**
     * Attributes
     */
    protected $table = 'beds';

    protected $primaryKey = 'bed_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'room_id',
    ];

    public $timestamps = false;

    /**
     * Retorna la habitación de la cama
     */
    public function room()
    {
        return $this->belongsTo('App\Room');
    }

    /**
     * Retorna el paciente de la cama
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
}
