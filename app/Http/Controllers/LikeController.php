<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Notifications\PostLiked;
use App\Services\LikeService;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    public function __construct(
        private readonly LikeService $likeService
    ) {}

    /**
     * Ajouter ou retirer un like.
     */
    public function toggle(Post $post): JsonResponse
    {
        $user = auth()->user();

        $result = $this->likeService->toggle(
            $user,
            $post
        );

        /*
         * Notification uniquement lors de l'ajout
         * d'un like et uniquement si l'utilisateur
         * n'est pas l'auteur de la publication.
         */
        if (
            $result['liked']
            && $post->user_id !== $user->id
        ) {
            $post->user->notify(
                new PostLiked($result['like'])
            );
        }

        return response()->json([
            'liked' => $result['liked'],
            'likes_count' => $result['likes_count'],
        ]);
    }
}