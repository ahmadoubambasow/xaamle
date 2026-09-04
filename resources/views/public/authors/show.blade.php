<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Profil de {{ $author->name }}
            </h2>
        </div>
    </x-slot>


    <div class="min-h-screen bg-gray-50 py-10">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">


            {{-- =========================================================
                 PROFIL AUTEUR
            ========================================================== --}}
            <section class="rounded-2xl border border-gray-200 bg-white">

                <div class="px-6 py-7 sm:px-8 sm:py-8">

                    <div class="flex flex-col gap-7 sm:flex-row sm:items-start">

                        {{-- =================================================
                             AVATAR
                        ================================================== --}}
                        <div class="shrink-0">

                            <div class="h-24 w-24 overflow-hidden rounded-full bg-gray-100 ring-1 ring-gray-200">

                                @if ($author->avatar)

                                    <x-cloudinary::image
                                        public-id="{{ $author->avatar }}"
                                        alt="Photo de {{ $author->name }}"
                                        class="h-full w-full object-cover"
                                    />

                                @else

                                    <div class="flex h-full w-full items-center justify-center bg-gray-900 text-3xl font-semibold text-white">
                                        {{ strtoupper(substr($author->name, 0, 1)) }}
                                    </div>

                                @endif

                            </div>

                        </div>


                        {{-- =================================================
                             INFORMATIONS
                        ================================================== --}}
                        <div class="min-w-0 flex-1">

                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                                <div class="min-w-0">

                                    <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                                        {{ $author->name }}
                                    </h1>

                                    <p class="mt-1 text-sm text-gray-400">
                                        Auteur sur Xaamlé
                                    </p>

                                </div>


                                {{-- Bouton suivre --}}
                                @auth

                                    @if (auth()->id() !== $author->id)

                                        <div class="shrink-0">
                                            <x-authors.follow-button :author="$author" />
                                        </div>

                                    @endif

                                @endauth

                            </div>


                            {{-- Bio --}}
                            @if ($author->bio)

                                <p class="mt-5 max-w-2xl text-sm leading-6 text-gray-600">
                                    {{ $author->bio }}
                                </p>

                            @else

                                <p class="mt-5 text-sm italic text-gray-400">
                                    Cet auteur n'a pas encore ajouté de présentation.
                                </p>

                            @endif


                            {{-- =================================================
                                 STATISTIQUES
                            ================================================== --}}
                            <div class="mt-6 flex flex-wrap items-center gap-x-8 gap-y-4">

                                <div class="flex items-center gap-2">

                                    <span class="text-base font-bold text-gray-900">
                                        {{ $posts->total() }}
                                    </span>

                                    <span class="text-sm text-gray-500">
                                        {{ $posts->total() > 1 ? 'publications' : 'publication' }}
                                    </span>

                                </div>


                                <div class="h-4 w-px bg-gray-200"></div>


                                <div class="flex items-center gap-2">

                                    <span class="text-base font-bold text-gray-900">
                                        {{ $author->followers()->count() }}
                                    </span>

                                    <span class="text-sm text-gray-500">
                                        {{ $author->followers()->count() > 1 ? 'abonnés' : 'abonné' }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =========================================================
                 PUBLICATIONS
            ========================================================== --}}
            <section class="mt-12">

                {{-- En-tête --}}
                <div class="mb-7 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">
                            Publications
                        </p>

                        <h2 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">
                            Les articles de {{ $author->name }}
                        </h2>

                    </div>

                    <p class="text-sm text-gray-400">
                        {{ $posts->total() }}
                        {{ $posts->total() > 1 ? 'articles publiés' : 'article publié' }}
                    </p>

                </div>


                {{-- =========================================================
                     LISTE DES ARTICLES
                ========================================================== --}}
                @if ($posts->count())

                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                        @foreach ($posts as $post)

                            <x-posts.card :post="$post" />

                        @endforeach

                    </div>


                    {{-- Pagination --}}
                    @if ($posts->hasPages())

                        <div class="mt-10">
                            {{ $posts->links() }}
                        </div>

                    @endif


                @else

                    {{-- =====================================================
                         AUCUNE PUBLICATION
                    ====================================================== --}}
                    <div class="rounded-2xl border border-gray-200 bg-white px-6 py-16 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">

                            <svg
                                class="h-6 w-6 text-gray-400"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6.75v10.5m-5.25-5.25h10.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                />

                            </svg>

                        </div>


                        <h3 class="mt-5 text-base font-semibold text-gray-900">
                            Aucune publication
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                            {{ $author->name }} n'a pas encore publié d'article sur Xaamlé.
                        </p>

                    </div>

                @endif

            </section>

        </div>

    </div>

</x-app-layout>