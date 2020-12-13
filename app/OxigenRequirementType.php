<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OxigenRequirementType extends Model
{
    const CANNULA = 'Canula nasal de oxígeno';
    const MASK = 'Máscara con reservorio';

    /**
     * Attributes
     */
    protected $table = 'oxigen_requirement_types';

    protected $primaryKey = 'oxigen_requirement_type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'oxigen_requirement_type',
    ];

    public $timestamps = false;

    public static function createOxigenRequirementType($name)
    {
        $ft = new OxigenRequirementType;
        $ft->oxigen_requirement_type = $name;
        $ft->save();
        return $ft;
    }
}
