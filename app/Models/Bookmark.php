<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(array $array)
 * @method static create(array $array)
 * @method static find($id)
 */
class Bookmark extends Model
{
    use HasFactory;
     protected $fillable = ['user_id', 'post_id'];


    public function user(){
         return $this->belongsTo(User::class);
     }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

     public function category()
     {
         return $this->belongsTo(Category::class);
     }
}
