<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly CommentService $commentService
    ) {}

    /**
     * Création d'un commentaire
     */
    public function store(
        StoreCommentRequest $request,
        Post $post
    ): JsonResponse|RedirectResponse {

        $comment = $this->commentService->create(
            $request->user(),
            $post,
            $request->validated('content')
        );

        if ($request->expectsJson()) {
            $comment->load('user');

            return response()->json([
                'message' => 'Votre commentaire a été ajouté.',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                    ],
                ],
                'comments_count' => $post->comments()->count(),
            ], 201);
        }

        return back()->with(
            'success',
            'Votre commentaire a été ajouté.'
        );
    }

    /**
     * Modification d'un commentaire
     */
    public function update(
        UpdateCommentRequest $request,
        Comment $comment
    ): JsonResponse|RedirectResponse {

        $comment = $this->commentService->update($comment, $request->validated('content'));

        $comment->load('user');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Votre commentaire a été modifié.',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                    ],
                ],
            ]);
        }

        return back()->with(
            'success',
            'Votre commentaire a été modifié.'
        );
    }

    /**
     * Suppression d'un commentaire
     */
    public function destroy(Comment $comment): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $comment);

        $post = $comment->post;

        $this->commentService->delete($comment);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Votre commentaire a été supprimé.',
                'comments_count' => $post->comments()->count(),
            ]);
        }

        return back()->with(
            'success',
            'Votre commentaire a été supprimé.'
        );
    }
}