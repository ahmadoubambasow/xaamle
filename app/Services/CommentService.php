<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentService
{
    /**
     * Création d'un commentaire
     */
    public function create(
        User $user,
        Post $post,
        string $content
    ): Comment {

        return $post->comments()->create([
            'user_id' => $user->id,
            'content' => trim($content),
        ]);
    }

    /**
     * Modification d'un commentaire
     */
    public function update(Comment $comment, string $content): Comment
    {
        $comment->update([
            'content' => trim($content),
        ]);

        return $comment->fresh();
    }

    /**
     * Supprimer un commentaire
     */
    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}