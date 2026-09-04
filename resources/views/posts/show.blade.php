@extends('layouts.public')

@section('content')

<main class="min-h-screen bg-gray-50 py-8 sm:py-10">

<article class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

    {{-- =========================================================
         RETOUR
    ========================================================== --}}

    <div class="mb-6">

        <a
            href="{{ route('home') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-gray-900"
        >
            <span>←</span>
            Retour aux publications
        </a>

    </div>


    {{-- =========================================================
         ARTICLE
    ========================================================== --}}

    <header class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        {{-- Image de couverture --}}
        @if ($post->cover_image)

            <div class="h-64 w-full sm:h-80 lg:h-96">

                <x-cloudinary::image
                    public-id="{{ $post->cover_image }}"
                    alt="{{ $post->title }}"
                    class="h-full w-full object-cover"
                />

            </div>

        @else

            <div class="flex h-48 items-center justify-center bg-gray-100 sm:h-56">

                <span class="text-5xl text-gray-300">
                    ✍️
                </span>

            </div>

        @endif


        {{-- Informations de l'article --}}
        <div class="px-6 py-8 sm:px-10 sm:py-10">

            {{-- Date --}}
            @if ($post->published_at)

                <p class="text-sm font-medium text-gray-400">
                    Publié le
                    {{ $post->published_at->translatedFormat('d F Y') }}
                </p>

            @endif


            {{-- Titre --}}
            <h1 class="mt-3 text-3xl font-bold leading-tight tracking-tight text-gray-900 sm:text-4xl lg:text-5xl">
                {{ $post->title }}
            </h1>


            {{-- Résumé --}}
            @if ($post->excerpt)

                <p class="mt-5 text-lg leading-8 text-gray-500">
                    {{ $post->excerpt }}
                </p>

            @endif


            {{-- Auteur --}}
            <div class="mt-7 flex items-center justify-between gap-4 border-t border-gray-100 pt-6">

                {{-- Informations auteur --}}
                <div class="flex min-w-0 items-center gap-3">

                    {{-- Avatar --}}
                    <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full">

                        @if ($post->user->avatar)

                            <x-cloudinary::image
                                public-id="{{ $post->user->avatar }}"
                                alt="Photo de {{ $post->user->name }}"
                                class="h-full w-full object-cover"
                            />

                        @else

                            <div class="flex h-full w-full items-center justify-center bg-gray-900 text-sm font-semibold text-white">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </div>

                        @endif

                    </div>

                    {{-- Nom et rôle --}}
                    <div class="min-w-0">

                        <p class="truncate text-sm font-semibold text-gray-900">
                            {{ $post->user->name }}
                        </p>

                        <p class="text-xs text-gray-400">
                            Auteur
                        </p>

                    </div>

                </div>

                {{-- Suivi --}}
                <div class="shrink-0">
                    <x-authors.follow-button :author="$post->user" />
                </div>

            </div>

        </div>

    </header>


    {{-- =========================================================
         CONTENU
    ========================================================== --}}

    <section class="mt-6 rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="px-6 py-8 sm:px-10 sm:py-10 lg:px-12">

            <div class="prose prose-gray max-w-none text-base leading-8 text-gray-700">

                {!! nl2br(e($post->content)) !!}

            </div>

        </div>

    </section>



    {{-- =========================================================
        BARRE D'INTERACTIONS
    ========================================================== --}}

    <section class="mt-4 rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="flex items-center justify-between px-4 py-3 sm:px-6">

            {{-- Gauche : Likes + commentaires --}}
            <div class="flex items-center gap-1 sm:gap-2">

                {{-- Like --}}
                @php
                    $likeCount = $post->likes()->count();

                    $hasLiked = auth()->check()
                        ? $post->likes()
                            ->where('user_id', auth()->id())
                            ->exists()
                        : false;
                @endphp

                @auth

                    <button
                        type="button"
                        id="like-button"
                        data-url="{{ route('posts.like', $post) }}"
                        data-liked="{{ $hasLiked ? 'true' : 'false' }}"
                        class="group inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium transition
                        {{ $hasLiked
                            ? 'text-red-600 hover:bg-red-50'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                        }}"
                    >

                        <span
                            id="like-icon"
                            class="text-xl leading-none transition-transform group-hover:scale-110"
                        >
                            {{ $hasLiked ? '❤️' : '♡' }}
                        </span>

                        <span id="like-count">
                            {{ $likeCount }}
                        </span>

                    </button>

                @else

                    <a
                        href="{{ route('login') }}"
                        class="group inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900"
                    >
                        <span class="text-xl leading-none">
                            ♡
                        </span>

                        <span>
                            {{ $likeCount }}
                        </span>
                    </a>

                @endauth


                {{-- Commentaires --}}
                <a
                    href="#comments"
                    class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900"
                >

                    <span class="text-xl leading-none">
                        💬
                    </span>

                    <span>
                        {{ $post->comments->count() }}
                    </span>

                </a>

            </div>


            {{-- Droite : Partager --}}
            <button
                type="button"
                id="copy-link"
                data-url="{{ route('public.posts.show', $post) }}"
                class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8.684 13.342C8.886 12.932 9 12.473 9 12s-.114-.932-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 110-2.684m0 2.684a3 3 0 100 2.684m0 0l-6.632 3.316"
                    />
                </svg>

                <span id="copy-link-text">
                    Partager
                </span>

            </button>

        </div>

    </section>


    {{-- =========================================================
        COMMENTAIRES
    ========================================================== --}}

    <div id="comments">

        <x-comments.section :post="$post" />

    </div>


    {{-- =========================================================
         INVITATION VISITEUR
    ========================================================== --}}

    @guest

        <section class="mt-6 overflow-hidden rounded-2xl bg-gray-900 px-6 py-8 text-center shadow-sm sm:px-10">

            <h2 class="text-xl font-bold text-white">
                Vous aimez ce que vous lisez ?
            </h2>

            <p class="mx-auto mt-2 max-w-lg text-sm leading-6 text-gray-300">
                Rejoignez Xaamlé et partagez à votre tour
                vos connaissances, vos expériences et vos idées.
            </p>

            <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">

                <a
                    href="{{ route('register') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-white px-5 py-3 text-sm font-semibold text-gray-900 transition hover:bg-gray-100"
                >
                    Rejoindre Xaamlé
                </a>

                <a
                    href="{{ route('login') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800"
                >
                    Se connecter
                </a>

            </div>

        </section>

    @endguest


    {{-- =========================================================
         ACTIONS DE L'AUTEUR
    ========================================================== --}}

    @auth

        @can('update', $post)

            <section class="mt-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h2 class="font-semibold text-gray-900">
                            Gérer cette publication
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Vous êtes l'auteur de cette publication.
                        </p>

                    </div>


                    <div class="flex flex-wrap gap-3">

                        {{-- Modifier --}}
                        <a
                            href="{{ route('posts.edit', $post) }}"
                            class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                        >
                            Modifier
                        </a>


                        {{-- Supprimer --}}
                        <x-confirm-delete
                            title="Supprimer cette publication ?"
                            message="Cette action est définitive. La publication « {{ $post->title }} » sera supprimée de façon permanente."
                            buttonText="Supprimer"
                        >

                            <form
                                action="{{ route('posts.destroy', $post) }}"
                                method="POST"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 sm:w-auto"
                                >
                                    Supprimer définitivement
                                </button>

                            </form>

                        </x-confirm-delete>

                    </div>

                </div>

            </section>

        @endcan

    @endauth

</article>


</main>

{{-- =========================================================
COPIE / PARTAGE DU LIEN
========================================================== --}}

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const button = document.getElementById('copy-link');
        const text = document.getElementById('copy-link-text');

        if (!button || !text) {
            return;
        }

        button.addEventListener('click', async function () {

            const url = this.dataset.url;
            const originalText = text.textContent;

            try {

                await navigator.clipboard.writeText(url);

                text.textContent = 'Lien copié ✓';

                setTimeout(() => {
                    text.textContent = originalText;
                }, 2000);

            } catch (error) {

                text.textContent = 'Impossible de copier';

                setTimeout(() => {
                    text.textContent = originalText;
                }, 2000);

            }

        });

    });

</script>

@endsection

@auth

<script>
document.addEventListener('DOMContentLoaded', function () {

    const button = document.getElementById('like-button');

    if (!button) {
        return;
    }

    const icon = document.getElementById('like-icon');
    const count = document.getElementById('like-count');

    button.addEventListener('click', async function () {

        // Évite plusieurs clics pendant la requête
        if (button.disabled) {
            return;
        }

        button.disabled = true;

        try {

            const response = await fetch(button.dataset.url, {

                method: 'POST',

                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'),

                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }

            });

            if (!response.ok) {
                throw new Error('Erreur lors du like.');
            }

            const data = await response.json();

            // Mise à jour du compteur
            count.textContent = data.likes_count;

            // Mise à jour de l'état
            button.dataset.liked = data.liked ? 'true' : 'false';

            if (data.liked) {

                icon.textContent = '❤️';

                button.classList.remove(
                    'text-gray-600',
                    'hover:bg-gray-100',
                    'hover:text-gray-900'
                );

                button.classList.add(
                    'text-red-600',
                    'hover:bg-red-50'
                );

            } else {

                icon.textContent = '♡';

                button.classList.remove(
                    'text-red-600',
                    'hover:bg-red-50'
                );

                button.classList.add(
                    'text-gray-600',
                    'hover:bg-gray-100',
                    'hover:text-gray-900'
                );

            }

        } catch (error) {

            console.error(error);

        } finally {

            button.disabled = false;

        }

    });

});
</script>

@endauth