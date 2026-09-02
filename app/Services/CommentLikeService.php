<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\User;

class CommentLikeService
{
    /**
     * Ajoute ou retire le like d'un utilisateur.
     */
    public function toggle(
        User $user,
        Comment $comment
    ): array {
        $like = $comment->likes()
            ->where('user_id', $user->id)
            ->first();

        if ($like) {
            $like->delete();

            return [
                'liked' => false,
                'likes_count' => $comment->likes()->count(),
            ];
        }

        $comment->likes()->create([
            'user_id' => $user->id,
        ]);

        return [
            'liked' => true,
            'likes_count' => $comment->likes()->count(),
        ];
    }
}