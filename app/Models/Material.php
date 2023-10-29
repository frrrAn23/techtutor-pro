<?php

namespace App\Models;

use App\Helpers\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory, Uuidable;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'name',
        'course_id',
        'topic_id',
        'content',
        'is_preview',
        'status',
        'video_url',
        'type',
        'duration_in_minutes',
        'order',
        'slug'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function isCompletedByUser($userId)
    {
        return $this->hasMany(UserMaterialProgress::class)->where('user_id', $userId)->where('material_id', $this->id)->exists();
    }

    public function userMaterialProgresses()
    {
        return $this->hasMany(UserMaterialProgress::class);
    }
}
