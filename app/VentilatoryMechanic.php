<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentilatoryMechanic extends Model
{
    const GOOD = 'Buena';
    const REGULAR = 'Regular';
    const BAD = 'Mala';

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

    public static function createVentilatoryMechanic($name)
    {
        $vm = new VentilatoryMechanic;
        $vm->ventilatory_mechanic = $name;
        $vm->save();
        return $vm;
    }

    /**
     * Obtener el id de una mecánica respiratoria por su nombre.
     * 
     * @return Integer.
     */
    public static function getIdByName($name)
    {
        return VentilatoryMechanic::where('ventilatory_mechanic', '=', $name)->first()->ventilatory_mechanic_id;
    }
}
