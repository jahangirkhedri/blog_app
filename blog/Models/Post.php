<?php

namespace Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id'];

    public function categories()
    {
        return $this->belongsToMany(Category::class,'categories_posts');
    }
}
