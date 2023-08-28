<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachingMaterialDownload extends Model
{
    use HasFactory;

      protected $fillable = [
        'materials_id',
        'downloadable',
    ];
}
