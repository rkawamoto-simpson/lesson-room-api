<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thumbnail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'materials_id',
        'users',
        'category',
        'sub_category',
        'lesson_name',
        'thumbnail',
        'name_en',
        'name_ja'
    ];
}
