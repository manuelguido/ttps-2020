<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    /**
     * Attributes
     */
    protected $table = 'systems';

    protected $primaryKey = 'system_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'system',
    ];

    public $timestamps = false;

    /**
     * Retorna los usuarios del sistema
     */
    public function users()
    {
        return $this->belongsToMany('App\User','role_user', 'role_id', 'user_id');
    }
}
