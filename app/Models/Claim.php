<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $fillable = ['title','user_id','post_id','status'];
    protected $table = 'users_claim_posts';

    function post(){
        return $this->belongsTo(Post::class);
    }
}
