<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medic extends Model
{
    /**
     * Attributes
     */
    protected $table = 'medics';

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     '',
    // ];

    public $timestamps = false;

    /**
     * Returns the medic user
     */
    public function user()
    {
        return $this->hasOne('App\User', 'user_id', 'user_id');
    }
}
