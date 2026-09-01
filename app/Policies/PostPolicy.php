<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determiner si l'utilisateur peut voir une publication privèe.
     */
    public function view(User $user, Post $post): bool
    {
        return $post->status === 'published' 
            || ($user !== null && $post->user_id === $user->id);
    }

    /**
     * Déterminer si l'utilisateur peut créer une publication.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Déterminer si l'utilisateur peut modifier une publication.
     */
    public function update(User $user, Post $post): bool
    {
        return $post->user_id === $user->id;
    }

    /**
     * Déterminer si l'utilisateur peut supprimer une publication
     */
    public function delete(User $user, Post $post): bool
    {
        return $post->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
