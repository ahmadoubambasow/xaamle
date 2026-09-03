<?php

namespace App\Services;

use App\Models\AuthorFollow;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AuthorFollowService
{
    /**
     * Suivre ou ne plus suivre un auteur.
     */
    public function toggle(User $follower, User $author): array
    {
        // Un utilisateur ne peut pas se suivre lui-même.
        if ($follower->id === $author->id) {
            throw new InvalidArgumentException(
                'Vous ne pouvez pas vous suivre vous-même.'
            );
        }

        return DB::transaction(function () use ($follower, $author) {

            $follow = AuthorFollow::query()
                ->where('follower_id', $follower->id)
                ->where('author_id', $author->id)
                ->first();

            if ($follow) {
                $follow->delete();

                return [
                    'following' => false,
                    'followers_count' => $author->followers()->count(),
                ];
            }

            AuthorFollow::create([
                'follower_id' => $follower->id,
                'author_id' => $author->id,
            ]);

            return [
                'following' => true,
                'followers_count' => $author->followers()->count(),
            ];
        });
    }

    /**
     * Vérifier si un utilisateur suit un auteur.
     */
    public function isFollowing(
        User $follower,
        User $author
    ): bool {
        return AuthorFollow::query()
            ->where('follower_id', $follower->id)
            ->where('author_id', $author->id)
            ->exists();
    }

    /**
     * Nombre d'abonnés d'un auteur.
     */
    public function followersCount(User $author): int
    {
        return $author->followers()->count();
    }
}