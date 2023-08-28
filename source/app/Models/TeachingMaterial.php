<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeachingMaterial extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'teaching_materials';

    protected $fillable = [
        'id',
        'materials_id',
        'users',
        'category',
        'sub_category',
        'teaching_materials',
        'name_en',
        'name_ja',
        'lesson_name',
        'file_name',
        'page',
    ];

    protected $casts = [
        'created_at' => 'date: Y-m-d',
        'updated_at' => 'date: Y-m-d',
    ];

    public function thumbnail(){
        return $this->hasOne(Thumbnail::class, 'materials_id', 'materials_id');
    }

    public function materialDownload()
    {
        return $this->hasOne(TeachingMaterialDownload::class, 'materials_id', 'materials_id');
    }

    public function materialLevels()
    {
        return $this->hasMany(TeachingMaterialLevel::class, 'teaching_material_id', 'id');
    }

    public function materialTargetAges()
    {
        return $this->hasMany(TeachingMaterialTargetAge::class, 'teaching_material_id', 'id');
    }
}
