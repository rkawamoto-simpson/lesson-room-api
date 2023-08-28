<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'room_id',
        'user_name',
        'user_agent',
        'version',
        'start_time',
        'end_time',
    ];

    public static function list($data)
    {
        $log = self::select('id', 'room_id', 'user_name', 'user_agent', 'version', 'start_time', 'end_time')
        ->where('room_id', $data['room_id'])
        ->where('user_name', $data['user_name'])
        ->whereNull('deleted_at')
        ->get();
        return $log;
    }
}
