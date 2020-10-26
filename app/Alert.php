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
        'patient_id', 'user_id', 'seen',
    ];

    public $timestamps = true;
}
