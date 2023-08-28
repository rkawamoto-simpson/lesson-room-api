<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomConfig extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'before_time',
        'after_time'
    ];

}
