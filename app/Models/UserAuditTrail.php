<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAuditTrail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'action', 'action_to', 'item_id'
    ];

    // Many-to-One Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Depending on the `action_to`, the item could refer to a Post or Comment
    public function post()
    {
        return $this->belongsTo(Post::class, 'item_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'item_id');
    }
}
