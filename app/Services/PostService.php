<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class PostService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }

    /**
    * Créer une publication
    */
    public function create(User $user, array $data): Post
    {
        $data['user_id'] = $user->id;
        
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        if (($data['status'] ?? 'draft') === 'published') {
            $data['published_at'] = now();
        } else {
            $data['published_at'] = null;
        }

        if (isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile) {
            $data['cover_image'] = $this->storeCoverImage($data['cover_image']);
        }

        return Post::create($data);
    }

    /**
     * Mettre à jour une publication
     */
    public function update(Post $post, array $data): Post
    {
        $data['slug'] = $this->generateUniqueSlug(
            $data['title'],
            $post->id
        );

        if (($data['status'] ?? 'draft') === 'published') {
            if (!$post->published_at) {
                $data['published_at'] = now();
            }
        } else {
            $data['published_at'] = null;
        }

        if (
            isset($data['cover_image'])
            && $data['cover_image'] instanceof UploadedFile
        ) {
            $data['cover_image'] = $this->storeCoverImage(
                $data['cover_image']
            );
        }

        $post->update($data);

        return $post->refresh();
    }

    /**
     * Générer un slug unique
     */
    private function generateUniqueSlug(string $title, ?int $ignorePostId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while ($this->slugExists($slug, $ignorePostId)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Vérifier si un slug existe déjà
     */
    private function slugExists(string $slug, ?int $ignorePostId = null): bool 
    {
        return Post::query()
            ->where('slug', $slug)
            ->when($ignorePostId, fn ($query) => $query->whereKeyNot($ignorePostId))
            ->exists();
    }

    /**
     * Stocker l'image de couverture
     */
    private function storeCoverImage(UploadedFile $file): string
    {
        return $file->store('posts/covers', 'public');
    }

    /**
     * Supprimer une publication
     */
    public function delete(Post $post): void
    {
        $post->delete();
    }
}
