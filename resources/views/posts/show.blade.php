@extends('layouts.public')

@section('content')

<main class="min-h-screen bg-gray-50 py-10">

    <article class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        {{-- Retour --}}
        <div class="mb-6">
            <a
                href="{{ route('home') }}"
                class="inline-flex items-center text-sm font-medium text-gray-500 transition hover:text-gray-900"
            >
                <span class="mr-2">←</span>
                Retour aux publications
            </a>
        </div>


        {{-- =========================================================
             EN-TÊTE DE L'ARTICLE
        ========================================================== --}}

        <header class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            {{-- Image de couverture --}}
            @if ($post->cover_image)

                <div class="h-64 w-full sm:h-80 lg:h-96">
                    <img
                        src="{{ asset('storage/' . $post->cover_image) }}"
                        alt="{{ $post->title }}"
                        class="h-full w-full object-cover"
                    >
                </div>

            @else

                <div class="flex h-48 items-center justify-center bg-gray-100 sm:h-56">
                    <span class="text-5xl text-gray-300">
                        ✍️
                    </span>
                </div>

            @endif


            {{-- Informations --}}
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
                <div class="mt-7 flex items-center gap-3 border-t border-gray-100 pt-6">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white">
                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                    </div>

                    <div>

                        <p class="text-sm font-semibold text-gray-900">
                            {{ $post->user->name }}
                        </p>

                        <p class="text-xs text-gray-400">
                            Auteur
                        </p>

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
             PARTAGE
        ========================================================== --}}

        <section class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="font-semibold text-gray-900">
                        Partager cette publication
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Faites découvrir cet article à votre entourage.
                    </p>

                </div>


                <button
                    type="button"
                    id="copy-link"
                    data-url="{{ route('public.posts.show', $post) }}"
                    class="inline-flex shrink-0 items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Copier le lien
                </button>

            </div>

        </section>


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

                <section class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

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
     COPIE DU LIEN
========================================================== --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const button = document.getElementById('copy-link');

        if (!button) {
            return;
        }

        button.addEventListener('click', async function () {

            const url = this.dataset.url;
            const originalText = this.textContent;

            try {

                await navigator.clipboard.writeText(url);

                this.textContent = 'Lien copié ✓';

                setTimeout(() => {
                    this.textContent = originalText;
                }, 2000);

            } catch (error) {

                this.textContent = 'Impossible de copier';

                setTimeout(() => {
                    this.textContent = originalText;
                }, 2000);

            }

        });

    });
</script>

@endsection