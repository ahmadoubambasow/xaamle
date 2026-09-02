<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentLike extends Model
{
    protected $fillable = [
        'comment_id',
        'user_id',
    ];

    /**
     * Commentaire liké
     */
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * Utilisateut ayant liké
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
