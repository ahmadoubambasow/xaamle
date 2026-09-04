<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Afficher les notifications de l'utilisateur connecté.
     */
    public function index(Request $request): View
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(15);

        return view('notifications.index', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Marquer une notification comme lue.
     */
    public function markAsRead(
        Request $request,
        string $notification
    ): RedirectResponse {
        $notification = $request->user()
            ->notifications()
            ->where('id', $notification)
            ->firstOrFail();

        $notification->markAsRead();

        /*
         * Si la notification concerne une publication,
         * rediriger directement vers cette publication.
         */
        $postId = $notification->data['post_id'] ?? null;

        if ($postId) {
            return redirect()->route(
                'public.posts.show',
                $postId
            );
        }

        return redirect()->route('notifications.index');
    }

    /**
     * Marquer toutes les notifications comme lues.
     */
    public function markAllAsRead(
        Request $request
    ): RedirectResponse {
        $request->user()
            ->unreadNotifications()
            ->update([
                'read_at' => now(),
            ]);

        return back();
    }
}