<?php

namespace App\Models;

use App\Helpers\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, Uuidable;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'name',
        'description',
        'price',
        'retail_price',
        'author_id',
        'thumbnail_url',
        'status',
        'slug',
        'level',
        'course_category_id',
        'labels',
        'type',
        'summary',
    ];

    protected $casts = [
        'labels' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_access_courses', 'course_id', 'user_id');
    }
}
