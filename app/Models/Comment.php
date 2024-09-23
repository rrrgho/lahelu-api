<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'post_id', 'comment_id', 'comment', 'video', 'likes'
    ];

    // One-to-Many Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Many-to-One Relationship with Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Many-to-One (Self-Referencing) Relationship with Comment
    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    // One-to-Many (Self-Referencing) Relationship with Comment
    public function replies()
    {
        return $this->hasMany(Comment::class, 'comment_id');
    }
}
