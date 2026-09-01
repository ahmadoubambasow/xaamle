<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;

class LikeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Ajouter ou retirer le like d'une publication 
     */
    public function toggle(User $user, Post $post): array
    {
        $like = $post->likes()
            ->where('user_id', $user->id)
            ->first();

        if ($like) {
            $like->delete();

            $liked = false;
        } else {
            $post->likes()->create([
                'user_id' => $user->id,
            ]);

            $liked = true;
        }

        return [
            'liked' => $liked,
            'likes_count' => $post->likes()->count(),
        ];
    }

}
