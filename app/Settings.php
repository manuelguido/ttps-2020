<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /**
     * Attributes
     */
    protected $table = 'settings';

    protected $primaryKey = 'setting_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'editing_days',
    ];

    public $timestamps = false;

    /**
     * Actualizar parametros de reglas.
     * 
     * @return void.
     */
    public function updateData($data)
    {
        $this->editing_days = $data->editing_days;
        $this->save();
    }

}
