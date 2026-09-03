<?php

namespace App\Services;

use App\Models\AuthorFollow;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;

class DashboardService
{
    /**
     * Préparer toutes les données nécessaires au dashboard.
     */
    public function getDashboardData(User $user): array
    {
        return [
            'user' => $user,
            'stats' => $this->getStats($user),
            'latestPosts' => $this->getLatestPosts($user),
            'discoverPosts' => $this->getDiscoverPosts($user),
            'activities' => $this->getRecentActivities($user),
        ];
    }

    /**
     * Statistiques personnelles.
     */
    protected function getStats(User $user): array
    {
        return [
            'posts' => $user->posts()->count(),

            'likes' => Like::query()
                ->whereHas('post', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->count(),

            'comments' => Comment::query()
                ->whereHas('post', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->count(),

            'followers' => $user->followers()->count(),
        ];
    }

    /**
     * Dernières publications de l'utilisateur.
     */
    protected function getLatestPosts(User $user): Collection
    {
        return $user->posts()
            ->withCount([
                'likes',
                'comments',
            ])
            ->latest()
            ->take(5)
            ->get();
    }

    /**
     * Publications à découvrir.
     */
    protected function getDiscoverPosts(User $user): Collection
    {
        return Post::query()
            ->where('user_id', '!=', $user->id)
            ->where('status', 'published')
            ->with([
                'user:id,name,avatar',
            ])
            ->withCount([
                'likes',
                'comments',
            ])
            ->orderByDesc('likes_count')
            ->latest('published_at')
            ->take(3)
            ->get();
    }

    /**
     * Construire l'activité récente.
     */
    protected function getRecentActivities(User $user): Collection
    {
        $activities = collect();

        $this->addLikeActivities($activities, $user);
        $this->addCommentActivities($activities, $user);
        $this->addFollowerActivities($activities, $user);

        return $activities
            ->sortByDesc('date')
            ->take(6)
            ->values();
    }

    /**
     * Activités liées aux likes.
     */
    protected function addLikeActivities(
        Collection $activities,
        User $user
    ): void {
        $likes = Like::query()
            ->whereHas('post', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('user_id', '!=', $user->id)
            ->with([
                'user:id,name,avatar',
                'post:id,title,slug',
            ])
            ->latest()
            ->take(5)
            ->get();

        foreach ($likes as $like) {
            $activities->push([
                'type' => 'like',
                'user' => $like->user,
                'post' => $like->post,
                'date' => $like->created_at,
            ]);
        }
    }

    /**
     * Activités liées aux commentaires.
     */
    protected function addCommentActivities(
        Collection $activities,
        User $user
    ): void {
        $comments = Comment::query()
            ->whereHas('post', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('user_id', '!=', $user->id)
            ->with([
                'user:id,name,avatar',
                'post:id,title,slug',
            ])
            ->latest()
            ->take(5)
            ->get();

        foreach ($comments as $comment) {
            $activities->push([
                'type' => 'comment',
                'user' => $comment->user,
                'post' => $comment->post,
                'date' => $comment->created_at,
            ]);
        }
    }

    /**
     * Activités liées aux nouveaux abonnés.
     */
    protected function addFollowerActivities(
        Collection $activities,
        User $user
    ): void {
        $followers = AuthorFollow::query()
            ->where('author_id', $user->id)
            ->with([
                'follower:id,name,avatar',
            ])
            ->latest()
            ->take(5)
            ->get();

        foreach ($followers as $follow) {
            $activities->push([
                'type' => 'follow',
                'user' => $follow->follower,
                'post' => null,
                'date' => $follow->created_at,
            ]);
        }
    }
}