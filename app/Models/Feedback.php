<?php

namespace App\Models;

use App\Helpers\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory, Uuidable;

    protected $table = 'feedbacks';

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'course_id',
        'user_id',
        'comment',
        'rating',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
