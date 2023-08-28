<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeachingMaterialTitle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name_en',
        'name_ja',
        'order',
        'thumbnail_en',
        'thumbnail_ja',
    ];

}
