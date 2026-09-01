<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\LikeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class LikeController extends Controller
{
    public function __construct(
        private readonly LikeService $likeService
    ) {}

    /**
     * Ajouter ou retirer un like
     */
    public function toggle(Post $post): JsonResponse
    {

        $liked = $this->likeService->toggle(
            auth()->user(),
            $post
        );

        return response()->json([
            'liked' => $liked,
            'likes_count' => $post->likes()->count(),
        ]);
    }
}
