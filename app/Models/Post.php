<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','slug','description','category_id','user_id','image','likes','status'];
    protected  static function booted()
    {
        self::creating(function ($post){
            $post->slug = Str::slug($post->title);
        });
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsto(User::class);
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsto(Category::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class,'likeable');
    }

    public function hiddenPosts(){
        return $this->belongsToMany(User::class,'users_hidden_posts');
    }



}
