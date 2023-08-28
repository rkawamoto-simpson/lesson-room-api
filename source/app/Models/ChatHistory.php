<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatHistory extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'chat_historys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'room_id',
        'name',
        'start_time',
        'end_time',
        'message',
        'type',
        'file_link',
        'file_name'
    ];

    public static function list($data)
    {
        $log = self::withTrashed()->select('id', 'room_id', 'name as username', 'start_time', 'end_time', 'message', 'created_at', 'deleted_at', 'type', 'file_link', 'file_name')
        ->where('room_id', $data['room_id'])
        ->get();
        return $log;
    }
}