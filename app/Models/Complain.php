<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $fillable = ['name','user_id','post_id','status'];


    function post(){
        return $this->belongsTo(Post::class);
    }
}
