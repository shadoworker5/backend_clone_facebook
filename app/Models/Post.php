<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $filleable = ['user_id', 'content', 'image_path'];

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function like(){
        return $this->hasMany(Like::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
