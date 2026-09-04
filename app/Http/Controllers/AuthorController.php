<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function show(User $author): View
    {
        $posts = $author->posts()
            ->where('status', 'published')
            ->withCount([
                'likes', 
                'comments'
            ])
            ->latest('published_at')
            ->paginate(9);
    

        return view('public.authors.show', [
            'author' => $author,
            'posts' => $posts
        ]);
    }
}