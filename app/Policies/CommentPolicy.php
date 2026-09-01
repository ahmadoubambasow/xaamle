<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Autoriser la modification uniquement
     * par l'auteur du commentaire.
     */
    public function update(
        User $user,
        Comment $comment
    ): bool {
        return $user->id === $comment->user_id;
    }

    /**
     * Autoriser la suppression uniquement
     * par l'auteur du commentaire.
     */
    public function delete(
        User $user,
        Comment $comment
    ): bool {
        return $user->id === $comment->user_id;
    }
}
