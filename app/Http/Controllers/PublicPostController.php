<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PublicPostController extends Controller
{
    /**
     * Afficher le fil public des publications
     */
    public function index(): View
    {
        $posts = Post::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->with('user')
            ->latest('published_at')
            ->paginate(9);

        
        return view ('public.posts.index', compact('posts'));
    }

    /**
     * Afficher une publication publiée.
     */
    public function show(Post $post): View
    {
        

        return view('posts.show', [
            'post' => $post->load('user'),
        ]);
    }
}