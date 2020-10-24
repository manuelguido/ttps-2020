<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * Attributes
     */
    protected $table = 'permissions';

    protected $primaryKey = 'permission_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission',
    ];

    public $timestamps = false;


    /**
     * Return  the users with this role
     */
    public function roles()
    {
        return $this->belongsToMany('App\User', 'permission_role', 'permission_id', 'role_id');
    }
}
