<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
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

    Route::view('/dashboard', 'dashboard')
        ->name('dashboard');


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
    
});


/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';