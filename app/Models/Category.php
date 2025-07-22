<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{

    use HasFactory;
    protected $fillable = ['name','image','slug','description'];

    protected static function booted(){
        self::creating(function ($category){
            $category->slug = Str::slug($category->name);
        });
    }
    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }
}
