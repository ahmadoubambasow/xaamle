<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'content',
    ];

    /**
     * Auteur du commentaire 
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Publication ayant le commentaire
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Commentaire parent
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * Reponses du commentaire
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Likes du commentaire
     */
    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }
}
