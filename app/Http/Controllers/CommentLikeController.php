<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Services\CommentLikeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    public function __construct(
        private readonly CommentLikeService $likeService
    ) {}
    
    /**
     * Ajouter ou retirer un like
     */
    public function toggle(Request $request, Comment $comment): JsonResponse
    {
        $result = $this->likeService->toggle(
            $request->user(),
            $comment
        );

        return response()->json([
            'message' => $result['liked']
                ? 'Commentaire aimé.'
                : 'Like retiré.',

            'liked' => $result['liked'],
            'likes_count' => $result['likes_count'],
        ]);

    }
}
