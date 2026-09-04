<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostCommented extends Notification
{
    use Queueable;

    public function __construct(
        public Comment $comment
    ) {
    }

    /**
     * Canaux utilisés par la notification.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Données enregistrées dans la table notifications.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'post_commented',

            'user_id' => $this->comment->user_id,

            'user_name' => $this->comment->user->name,

            'post_id' => $this->comment->post_id,

            'post_title' => $this->comment->post->title,

            'comment_id' => $this->comment->id,

            'comment_content' => $this->comment->content,

            'message' => $this->comment->user->name
                . ' a commenté votre publication.',
        ];
    }
}