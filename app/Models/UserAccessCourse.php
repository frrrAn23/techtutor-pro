<?php

namespace App\Models;

use App\Helpers\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccessCourse extends Model
{
    use HasFactory, Uuidable;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'course_id',
        'user_id',
        'purchased_at',
        'completed_at',
        'last_material_id',
        'status'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonymous',
        ]);
    }

    public function lastMaterial()
    {
        return $this->belongsTo(Material::class, 'last_material_id');
    }
}
