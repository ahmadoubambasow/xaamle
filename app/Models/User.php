<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'bio'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Envoyer l'email personnalisé de vérification
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }

    /**
     * Envoyer l'e-mail personnalisé de réinitialisation.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(
            new ResetPasswordNotification($token)
        );
    }
    

    /**
     * Publicaton de l'utilisateur
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Likes effectués par l'uitlisateur
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Commentaires effectués par l'uitlisateur
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Likes donnés aux commentaires
     */
    public function commentLikes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }
    
    /**
     * Les auteurs que cet utilisateur suit
     */
    public function following(): HasMany
    {
        return $this->hasMany(AuthorFollow::class, 'follower_id');
    }

    /**
     * es utilisateurs qui suivent cet auteur
     */
    public function followers(): HasMany
    {
        return $this->hasMany(AuthorFollow::class, 'author_id');
    }

    /**
     * Est-ce que cet utilisateur suit cet auteur
     */
    public function isFollowing(User $author): bool
    {
        return $this->following()
            ->where('author_id', $author->id)
            ->exists();
    }

    /**
     * Le nombre de personnes qui suivent cet utilisateur
     */
    public function followersCount(): int
    {
        return $this->followers()->count();
    }
}
