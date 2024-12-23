<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','post_id', 'text'];

    public function posts()
    {
        return $this->belongsto(Task::class);
    }

    public function user()
    {
        return $this->belongsto(User::class);
    }

}

