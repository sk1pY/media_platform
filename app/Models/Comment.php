<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function tasks()
    {
        return $this->belongsto(Task::class);
    }

    public function user()
    {
        return $this->belongsto(User::class);
    }

    protected $fillable = ['user_id','task_id', 'text'];
}

