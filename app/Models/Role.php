<?php

namespace App\Models;

use App\Helpers\Uuidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, Uuidable;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
