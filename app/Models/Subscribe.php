<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PharIo\Manifest\Author;

class Subscribe extends Model
{
    use HasFactory;
    protected $fillable = [
        'author_id',
        'user_id',
    ];




}
