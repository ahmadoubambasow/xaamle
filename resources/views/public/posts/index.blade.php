@extends('layouts.public')

    @section('content')
        <main class="min-h-screen bg-gray-50">

            {{-- Hero --}}
            <section class="border-b border-gray-200 bg-white">

                <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">

                    <div class="max-w-3xl">

                        <p class="text-sm font-semibold uppercase tracking-wider text-gray-500">
                            Faire savoir
                        </p>

                        <h1 class="mt-3 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                            Les idées méritent
                            <span class="text-gray-500">
                                d'être partagées.
                            </span>
                        </h1>

                        <p class="mt-6 max-w-2xl text-lg leading-8 text-gray-600">
                            Découvrez des connaissances, des expériences et des
                            idées partagées par les membres de la communauté Xaamlé.
                        </p>

                        @guest
                            <div class="mt-8 flex flex-wrap gap-3">

                                <a
                                    href="{{ route('register') }}"
                                    class="inline-flex items-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800"
                                >
                                    Rejoindre Xaamlé
                                </a>

                                <a
                                    href="{{ route('login') }}"
                                    class="inline-flex items-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                                >
                                    Se connecter
                                </a>

                            </div>
                        @endguest

                    </div>

                </div>

            </section>


            {{-- Publications --}}
            <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">

                <div class="mb-8 flex items-end justify-between gap-4">

                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            Dernières publications
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Les contenus récemment partagés par la communauté.
                        </p>
                    </div>

                </div>


                @if ($posts->count())

                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                        @foreach ($posts as $post)

                            <article class="group flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md">

                                {{-- Image --}}
                                @if ($post->cover_image)

                                    <a
                                        href="{{ route('public.posts.show', $post) }}"
                                        class="block h-52 overflow-hidden"
                                    >
                                        <x-cloudinary::image
                                            public-id="{{ $post->cover_image }}"
                                            alt="{{ $post->title }}"
                                            class="h-full w-full object-cover"
                                        />
                                    </a>

                                @else

                                    <a
                                        href="{{ route('public.posts.show', $post) }}"
                                        class="flex h-52 items-center justify-center bg-gray-100"
                                    >
                                        <span class="text-5xl text-gray-300">
                                            ✍️
                                        </span>
                                    </a>

                                @endif


                                {{-- Contenu --}}
                                <div class="flex flex-1 flex-col p-6">

                                    <div class="flex items-center gap-2 text-xs text-gray-400">

                                        <span>
                                            {{ $post->published_at->translatedFormat('d F Y') }}
                                        </span>

                                    </div>


                                    <h3 class="mt-3 text-xl font-bold leading-tight text-gray-900">

                                        <a
                                            href="{{ route('public.posts.show', $post) }}"
                                            class="transition hover:text-gray-600"
                                        >
                                            {{ $post->title }}
                                        </a>

                                    </h3>


                                    @if ($post->excerpt)

                                        <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-500">
                                            {{ $post->excerpt }}
                                        </p>

                                    @endif


                                   {{-- Auteur --}}
                                    <div class="mt-auto border-t border-gray-100 pt-5">

                                        <a
                                            href="{{ route('authors.show', $post->user) }}"
                                            class="flex items-center gap-3 rounded-lg transition hover:opacity-80"
                                        >

                                            {{-- Avatar --}}
                                            <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full">

                                                @if ($post->user->avatar)

                                                    <x-cloudinary::image
                                                        public-id="{{ $post->user->avatar }}"
                                                        alt="Photo de {{ $post->user->name }}"
                                                        class="h-full w-full object-cover"
                                                    />

                                                @else

                                                    <div class="flex h-full w-full items-center justify-center bg-gray-900 text-xs font-semibold text-white">
                                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                                    </div>

                                                @endif

                                            </div>

                                            {{-- Informations auteur --}}
                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-semibold text-gray-900">
                                                    {{ $post->user->name }}
                                                </p>

                                                <p class="text-xs text-gray-400">
                                                    Auteur
                                                </p>

                                            </div>

                                        </a>

                                    </div>


                                    {{-- Lire --}}
                                    <a
                                        href="{{ route('public.posts.show', $post) }}"
                                        class="mt-5 inline-flex items-center text-sm font-semibold text-gray-900 transition group-hover:text-gray-500"
                                    >
                                        Lire l'article
                                        <span class="ml-2 transition group-hover:translate-x-1">
                                            →
                                        </span>
                                    </a>

                                </div>

                            </article>

                        @endforeach

                    </div>


                    {{-- Pagination --}}
                    <div class="mt-10">
                        {{ $posts->links() }}
                    </div>


                @else

                    {{-- Aucun article --}}
                    <div class="rounded-2xl border border-gray-200 bg-white px-6 py-16 text-center shadow-sm">

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                            <span class="text-3xl">
                                ✍️
                            </span>
                        </div>

                        <h3 class="mt-5 text-lg font-semibold text-gray-900">
                            La communauté commence ici
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                            Il n'y a pas encore de publication.
                            Soyez le premier à partager quelque chose avec la communauté.
                        </p>

                        @auth
                            <a
                                href="{{ route('posts.create') }}"
                                class="mt-6 inline-flex items-center rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                            >
                                Écrire ma première publication
                            </a>
                        @else
                            <a
                                href="{{ route('register') }}"
                                class="mt-6 inline-flex items-center rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                            >
                                Rejoindre la communauté
                            </a>
                        @endauth

                    </div>

                @endif

            </section>

        </main>

@endsection