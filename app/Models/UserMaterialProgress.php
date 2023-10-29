<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMaterialProgress extends Model
{
    use HasFactory;

    protected $table = 'user_material_progress';
    protected $fillable = [
        'user_id',
        'material_id',
        'course_id',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
