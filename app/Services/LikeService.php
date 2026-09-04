<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;

class LikeService
{
    /**
     * Ajouter ou retirer le like d'une publication.
     */
    public function toggle(User $user, Post $post): array
    {
        $like = $post->likes()
            ->where('user_id', $user->id)
            ->first();

        if ($like) {
            $like->delete();

            return [
                'liked' => false,
                'likes_count' => $post->likes()->count(),
                'like' => null,
            ];
        }

        $like = $post->likes()->create([
            'user_id' => $user->id,
        ]);

        return [
            'liked' => true,
            'likes_count' => $post->likes()->count(),
            'like' => $like,
        ];
    }
}