<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTag extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['post_id', 'tag_id'];

    // Belongs to Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Belongs to Tag
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
