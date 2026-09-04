<?php

namespace App\Http\Controllers;

use App\Models\AuthorFollow;
use App\Models\User;
use App\Services\AuthorFollowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;

class AuthorFollowController extends Controller
{
    public function __construct(
        private readonly AuthorFollowService $followService
    ) {}

    /**
     * Afficher tous les comptes suivis par l'utilisateur.
     */
    public function index(Request $request): View
    {
        $following = AuthorFollow::query()
            ->where('follower_id', $request->user()->id)
            ->with([
                'author' => function ($query) {
                    $query->withCount([
                        'posts' => function ($query) {
                            $query->where('status', 'published');
                        },
                        'followers',
                    ]);
                },
            ])
            ->latest()
            ->paginate(12);

        return view('authors.following', [
            'following' => $following,
        ]);
    }


    /**
     * Suivre / ne plus suivre un auteur
     */
    public function toggle(Request $request, User $author): JsonResponse
    {
        try {
            $result = $this->followService->toggle(
                $request->user(),
                $author
            );

            return response()->json([
                'message' => $result['following']
                    ? 'Vous suivez maintenant cet auteur.'
                    : 'Vous ne suivez plus cet auteur.',

                'following' => $result['following'],
                'followers_count' => $result['followers_count'],
            ]);
        } catch (InvalidArgumentException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ],422);
        }
    }

}
