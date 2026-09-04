<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthorFollowController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

// Accueil — feed public Xaamlé
Route::get('/', [PublicPostController::class, 'index'])
    ->name('home');

// Lecture d'une publication
Route::get('/articles/{post}', [PublicPostController::class, 'show'])
    ->name('public.posts.show');

Route::get('/auteurs/{author}', [AuthorController::class, 'show'])
    ->name('authors.show');


/*
|--------------------------------------------------------------------------
| Routes authentifiées
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Tableau de bord
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    Route::get('/mes-abonnements', [AuthorFollowController::class, 'index'])
        ->name('authors.following');


    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.read-all');

    /*
    |--------------------------------------------------------------------------
    | Profil
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Mes publications
    |--------------------------------------------------------------------------
    */

    Route::get('/posts', [PostController::class, 'index'])
        ->name('posts.index');

    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');

    Route::put('/posts/{post}', [PostController::class, 'update'])
        ->name('posts.update');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');


    /*
    |--------------------------------------------------------------------------
    | Likes
    |--------------------------------------------------------------------------
    */
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])
        ->name('posts.like');

    Route::post('/comments/{comment}/like', [CommentLikeController::class, 'toggle'])
        ->name('comments.likes.toggle');

    /*
    |--------------------------------------------------------------------------
    | Commentaires
    |--------------------------------------------------------------------------
    */
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
    
    Route::put('/comments/{comment}', [CommentController::class, 'update'])
        ->name('comments.update');
    
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');
    
    Route::post('/comments/{comment}/replies', [CommentController::class, 'reply'])
        ->name('comments.replies.store');


    /*
    |--------------------------------------------------------------------------
    | Suivre des auteurs
    |--------------------------------------------------------------------------
    */
    Route::post('/authors/{author}/follow', [AuthorFollowController::class, 'toggle'])
        ->name('authors.follow.toggle');
});


/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';