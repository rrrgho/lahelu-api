<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'id' => 'string',
    ];

    protected $fillable = [
        'user_id', 'caption', 'image', 'video', 'like', 'unlike', 
        'is_sensitive', 'is_onrule'
    ];

    // One-to-Many Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Many-to-Many Relationship with Tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }

    // One-to-Many Relationship with Comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
