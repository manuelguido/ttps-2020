<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentilatoryMechanic extends Model
{
    const VM_GOOD = 'Buena';
    const VM_REGULAR = 'Regular';
    const VM_BAD = 'Mala';

    /**
     * Attributes
     */
    protected $table = 'ventilatory_mechanics';

    protected $primaryKey = 'ventilatory_mechanic_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ventilatory_mechanic',
    ];

    public $timestamps = false;

}
