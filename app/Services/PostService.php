<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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

        $data['slug'] = $this->generateUniqueSlug(
            $data['title']
        );

        if (($data['status'] ?? 'draft') === 'published') {
            $data['published_at'] = now();
        } else {
            $data['published_at'] = null;
        }

        /*
         * Upload de l'image de couverture sur Cloudinary
         */
        if (
            isset($data['cover_image']) &&
            $data['cover_image'] instanceof UploadedFile
        ) {
            $data['cover_image'] = $this->storeCoverImage(
                $data['cover_image']
            );
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

        /*
         * Gestion du statut de publication
         */
        if (($data['status'] ?? 'draft') === 'published') {

            if (!$post->published_at) {
                $data['published_at'] = now();
            }

        } else {

            $data['published_at'] = null;
        }

        /*
         * Nouvelle image de couverture
         */
        if (
            isset($data['cover_image']) &&
            $data['cover_image'] instanceof UploadedFile
        ) {

            /*
             * Supprimer l'ancienne couverture Cloudinary
             */
            if (
                $post->cover_image &&
                str_starts_with(
                    $post->cover_image,
                    'xaamle/posts/'
                )
            ) {
                try {
                    Cloudinary::uploadApi()->destroy(
                        $post->cover_image,
                        [
                            'resource_type' => 'image',
                        ]
                    );
                } catch (\Throwable $e) {
                    /*
                     * Ne pas bloquer la mise à jour
                     * si la suppression échoue.
                     */
                }
            }

            /*
             * Upload de la nouvelle couverture
             */
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
    private function generateUniqueSlug(
        string $title,
        ?int $ignorePostId = null
    ): string {
        $baseSlug = Str::slug($title);

        $slug = $baseSlug;

        $counter = 1;

        while (
            $this->slugExists(
                $slug,
                $ignorePostId
            )
        ) {
            $slug = $baseSlug . '-' . $counter;

            $counter++;
        }

        return $slug;
    }

    /**
     * Vérifier si un slug existe déjà
     */
    private function slugExists(
        string $slug,
        ?int $ignorePostId = null
    ): bool {
        return Post::query()
            ->where('slug', $slug)
            ->when(
                $ignorePostId,
                fn ($query) => $query->whereKeyNot($ignorePostId)
            )
            ->exists();
    }

    /**
     * Envoyer l'image de couverture sur Cloudinary
     *
     * @return string Public ID Cloudinary
     */
    private function storeCoverImage(
        UploadedFile $file
    ): string {
        $result = Cloudinary::uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder' => 'xaamle/posts',
            ]
        );

        return $result['public_id'];
    }

    /**
     * Supprimer une publication
     */
    public function delete(Post $post): void
    {
        /*
         * Supprimer l'image de couverture de Cloudinary
         */
        if (
            $post->cover_image &&
            str_starts_with(
                $post->cover_image,
                'xaamle/posts/'
            )
        ) {
            try {
                Cloudinary::uploadApi()->destroy(
                    $post->cover_image,
                    [
                        'resource_type' => 'image',
                    ]
                );
            } catch (\Throwable $e) {
                /*
                 * Ne pas empêcher la suppression
                 * du post si Cloudinary rencontre une erreur.
                 */
            }
        }

        /*
         * Supprimer le post
         */
        $post->delete();
    }
}