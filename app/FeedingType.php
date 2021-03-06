<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedingType extends Model
{
    const ORAL = 'Oral';
    const ENTERAL = 'Enteral';
    const PARENTERAL = 'Parenteral';

    /**
     * Attributes
     */
    protected $table = 'feeding_types';

    protected $primaryKey = 'feeding_type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'feeding_type',
    ];

    public $timestamps = false;

    public static function createFeedingType($name)
    {
        $ft = new FeedingType;
        $ft->feeding_type = $name;
        $ft->save();
        return $ft;
    }
}
