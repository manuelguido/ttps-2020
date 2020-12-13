<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RuleSettings extends Model
{
    /**
     * Mensajes de alertas
     */
    const MESSAGE_E1 = 'Evaluar pase a UTI.'; // Alertas 1,2,3
    const MESSAGE_E2 = 'Evaluar alta.'; // Alerta 4
    const MESSAGE_E3 = 'Evaluar oxigenoterapia y prono.'; // Alertas 5,6

    /**
     * Attributes
     */
    protected $table = 'rule_settings';

    protected $primaryKey = 'rule_setting_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activated', 'breathing_rate', 'days_to_evaluate', 'oxigen_saturation', 'oxigen_saturation_down_percentage',
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
