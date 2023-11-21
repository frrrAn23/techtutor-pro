<?php

namespace App\Models;

use App\Helpers\Uuidable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Uuidable;

    public $incrementing = false;

    protected $keyType = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone_number',
        'last_education',
        'status',
        'username',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'user_access_courses', 'user_id', 'course_id')
            ->withPivot('purchased_at', 'completed_at', 'last_material_id', 'status');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function authorCourses()
    {
        return $this->hasMany(Course::class, 'author_id');
    }

    public function userAccessCourses()
    {
        return $this->hasMany(UserAccessCourse::class);
    }
}
