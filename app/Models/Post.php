<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Post extends Model
{
    use HasFactory;
    protected $attributes = [
        'image' => 'public/default_images/default.png',
    ];
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'user_id',
        'image',
        'likes'
    ];

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
        return $this->belongsToMany(User::class,'post_like_user');
    }



}
