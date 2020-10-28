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
     * Retorna los usuarios del sistema
     */
    public function users()
    {
        return $this->belongsToMany('App\User','role_user', 'role_id', 'user_id');
    }

    /**
     * Retorna los pacientes del sistema
     */
    public function patients()
    {
        return $this->hasMany('App\Patient', 'patient_id', 'system_id');
    }

    /**
     * Retorna las habitaciones del sistema
     */
    public function rooms()
    {
        return $this->hasMany('App\Room', 'room_id', 'system_id');
    }

    /**
     * Retorna el total de salas del sistema
     */
    public function totalRooms()
    {
        // Resultado de consulta
        $result = DB::table('rooms')
            ->where('system_id', '=', $this->system_id)
            ->get();

        // Retorna el resultado
        return count($result);
    }

    /**
     * Retorna el total de camas del sistema
     */
    public function totalBeds()
    {
        // Resultado de consulta
        $result = DB::table('rooms')
            ->where('rooms.system_id', '=', $this->system_id)
            ->join('beds', 'beds.room_id', '=', 'rooms.room_id')
            ->get();

        // Retorna el resultado
        return count($result);
    }

    /**
     * Retorna el total de habitaciones ocupadas del sistema
     */
    public function occupiedBeds()
    {
        // Resultado de consulta
        $result = DB::table('rooms')
            ->where([
                ['rooms.system_id', '=', $this->system_id],
                ['beds.is_occupied', '=', true],
            ])
            ->join('beds', 'beds.room_id', '=', 'rooms.room_id')
            ->get();

        return count($result);
    }

    /**
     * Retorna el total de habitaciones ocupadas del sistema
     */
    public function freeBeds()
    {
        // Resultado de consulta
        $result = DB::table('rooms')
            ->where([
                ['rooms.system_id', '=', $this->system_id],
                ['beds.is_occupied', '=', false],
            ])
            ->join('beds', 'beds.room_id', '=', 'rooms.room_id')
            ->get();

        return count($result);
    }


    
    /**
     * Retorna si el sistema tiene camas disponibles
     */
    public function hasBeds()
    {
        return ($this->freeBeds() > 0);
    }


    /**
     * Carga una nueva cama en el sistema (La siguiente disponible) 
     */
    public function ocuppyNewBed($patient_id)
    {
        $bed = Bed::where([
            ['beds.is_occupied', '=', FALSE],
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
