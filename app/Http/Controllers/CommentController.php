<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreReplyRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\PostCommented;
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

        $user = $request->user();

        $comment = $this->commentService->create(
            $user,
            $post,
            $request->validated('content')
        );

        /*
        * Charger les relations nécessaires à la notification
        * et à la réponse JSON.
        */
        $comment->load('user');

        /*
        * Notification à l'auteur de la publication.
        *
        * On ne notifie pas l'auteur s'il commente
        * lui-même sa propre publication.
        */
        if ($post->user_id !== $user->id) {
            $post->user->notify(
                new PostCommented($comment)
            );
        }

        if ($request->expectsJson()) {

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

                    'likes_count' => 0,
                    'liked' => false,
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

    /**
     * Création d'une réponse
     */
    public function reply(StoreReplyRequest $request, Comment $comment): JsonResponse|RedirectResponse
    {
        $reply = $this->commentService->createReply(
            $request->user(),
            $comment,
            $request->validated('content')
        );

        $reply->load('user');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Votre réponse a été ajoutée.',
                'reply' => [
                    'id' => $reply->id,
                    'content' => $reply->content,
                    'created_at' => $reply->created_at->diffForHumans(),
                    'user' => [
                        'id' => $reply->user->id,
                        'name' => $reply->user->name,
                    ],
                ],
            ], 201);
        }

        return back()->with(
            'success',
            'Votre réponse a été ajoutée.'
        );
    }
}