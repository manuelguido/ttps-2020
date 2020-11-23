<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bed;
use DB;

class System extends Model
{
    const SYSTEM_GUARD = 'Guardia';
    const SYSTEM_COVID_FLOOR = 'Piso Covid';
    const SYSTEM_UTI = 'UTI';
    const SYSTEM_HOTEL = 'Hotel';
    const SYSTEM_HOME = 'Domicilio';

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
        'system', 'infinite_beds',
    ];

    public $timestamps = false;

    /**
     * Obtener las notificaciones del sistema.
     * 
     * @return App\Alert.
     */
    public function alerts()
    {
        return $this->hasMany('App\Alert');
    }

    /**
     * Obtener los usuarios del sistema.
     * 
     * @return App\User.
     */
    public function users()
    {
        return $this->belongsToMany('App\User','role_user', 'role_id', 'user_id');
    }

    /**
     * Obtener los pacientes del sistema.
     * 
     * @return App\Patient.
     */
    public function patients()
    {
        return $this->hasMany('App\Patient', 'patient_id', 'system_id');
    }

    /**
     * Obtener las habitaciones del sistema.
     * 
     * @return App\Room.
     */
    public function rooms()
    {
        return $this->hasMany('App\Room', 'room_id', 'system_id');
    }

    /**
     * Obtener el total de salas del sistema
     * 
     * @return Integer.
     */
    public function totalRooms()
    {
        return DB::table('rooms')->where('system_id', '=', $this->system_id)->get()->count();
    }

    /**
     * Obtener el total de camas del sistema
     * 
     * @return Integer.
     */
    public function totalBeds()
    {
        return DB::table('rooms')->where('rooms.system_id', '=', $this->system_id)->join('beds', 'beds.room_id', '=', 'rooms.room_id')->get()->count();
    }

    /**
     * Obtener el total de habitaciones ocupadas del sistema
     * 
     * @return Integer.
     */
    public function occupiedBeds()
    {
        return DB::table('rooms')
            ->where([
                ['rooms.system_id', '=', $this->system_id],
                ['beds.is_occupied', '=', true],
            ])
            ->join('beds', 'beds.room_id', '=', 'rooms.room_id')
            ->get()
            ->count();
    }

    /**
     * Obtener el total de habitaciones ocupadas del sistema
     * 
     * @return Integer.
     */
    public function freeBeds()
    {
        return DB::table('rooms')
            ->where([
                ['rooms.system_id', '=', $this->system_id],
                ['beds.is_occupied', '=', false],
            ])
            ->join('beds', 'beds.room_id', '=', 'rooms.room_id')
            ->get()
            ->count();
    }

    /**
     * Obtener si el sistema tiene camas disponibles
     * 
     * @return Boolean.
     */
    public function hasBeds()
    {
        return ($this->freeBeds() > 0);
    }

    /**
     * Cargar una nueva cama en el sistema (La siguiente disponible)
     * 
     * @return void.
     */
    public function ocuppyNewBed($patient_id)
    {
        $bed = Bed::where([
            ['beds.is_occupied', '=', false],
            ['rooms.system_id', '=', $this->system_id]
            ])
            ->join('rooms', 'rooms.room_id', '=', 'beds.room_id')
            ->orderBy('number', 'ASC')
            ->first();

        $bed->patient_id = $patient_id;
        $bed->is_occupied = True;
        $bed->save();
    }
}
