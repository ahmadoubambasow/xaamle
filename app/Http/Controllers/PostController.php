<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    /**
     * Liste des publications
     */
    public function index(): View
    {
        $posts = auth()->user()
            ->posts()
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Formulaire de création
     */
    public function create(): View
    {
        return view('posts.create');
    }

    /**
     * Enregistrer une publication.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $post = $this->postService->create(
            $request->user(),
            $request->validated()
        );

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Publication créée avec succès.');
    }

    /**
     * Afficher une publication.
     */
    public function show(Post $post): View
    {
        Gate::authorize('view', $post);

        return view('posts.show', [
            'post' => $post->load('user'),
        ]);
    }

    /**
     * Formulaire de modification
     */
    public function edit(Post $post): View
    {
        Gate::authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    /**
     * Mettre à jour une publication.
     */
    public function update(
        UpdatePostRequest $request,
        Post $post
    ): RedirectResponse {
        Gate::authorize('update', $post);

        $post = $this->postService->update(
            $post,
            $request->validated()
        );

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Publication mise à jour avec succès.');
    }

    /**
     * Supprimer une publication.
     */
    public function destroy(Post $post): RedirectResponse
    {
        Gate::authorize('delete', $post);

        $this->postService->delete($post);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Publication supprimée avec succès.');
    }
}