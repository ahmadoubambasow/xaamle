@props(['following'])

@php
    $authors = $following['authors'];
    $total = $following['total'];
@endphp

<section class="rounded-2xl border border-gray-200 bg-white shadow-sm">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}

    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5">

        <div class="min-w-0">

            <h2 class="text-lg font-semibold text-gray-900">
                Comptes suivis
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Les auteurs que vous suivez
            </p>

        </div>


        {{-- Nombre total --}}
        @if ($total > 0)

            <span
                class="shrink-0 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600"
            >
                {{ $total }}
            </span>

        @endif

    </div>



    {{-- =========================================================
         CONTENU
    ========================================================== --}}

    <div class="p-6">

        @if ($authors->isEmpty())

            {{-- =================================================
                 AUCUN ABONNEMENT
            ================================================== --}}

            <div class="py-5 text-center">

                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-lg"
                >
                    👤
                </div>

                <p class="mt-3 text-sm font-semibold text-gray-900">
                    Aucun compte suivi
                </p>

                <p class="mt-1 text-sm leading-6 text-gray-500">
                    Découvrez des auteurs et suivez leurs publications.
                </p>

                <a
                    href="{{ route('home') }}"
                    class="mt-4 inline-flex items-center rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800"
                >
                    Découvrir les auteurs
                </a>

            </div>

        @else

            {{-- =================================================
                 LISTE LIMITÉE
            ================================================== --}}

            <div class="space-y-4">

                @foreach ($authors as $author)

                    <div class="flex items-center justify-between gap-3">

                        {{-- Auteur --}}
                        <a
                            href="{{ route('authors.show', $author) }}"
                            class="flex min-w-0 items-center gap-3"
                        >

                            {{-- Avatar --}}
                            <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full">

                                @if ($author->avatar)

                                    <x-cloudinary::image
                                        public-id="{{ $author->avatar }}"
                                        alt="Photo de {{ $author->name }}"
                                        class="h-full w-full object-cover"
                                    />

                                @else

                                    <div
                                        class="flex h-full w-full items-center justify-center bg-gray-900 text-sm font-semibold text-white"
                                    >
                                        {{ strtoupper(substr($author->name, 0, 1)) }}
                                    </div>

                                @endif

                            </div>


                            {{-- Informations --}}
                            <div class="min-w-0">

                                <p class="truncate text-sm font-semibold text-gray-900">
                                    {{ $author->name }}
                                </p>

                                <p class="mt-0.5 text-xs text-gray-500">

                                    {{ $author->posts_count }}

                                    {{ $author->posts_count > 1
                                        ? 'publications'
                                        : 'publication'
                                    }}

                                    <span class="mx-1 text-gray-300">
                                        •
                                    </span>

                                    {{ $author->followers_count }}

                                    {{ $author->followers_count > 1
                                        ? 'abonnés'
                                        : 'abonné'
                                    }}

                                </p>

                            </div>

                        </a>


                        {{-- Profil --}}
                        <a
                            href="{{ route('authors.show', $author) }}"
                            class="shrink-0 rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-700 transition hover:border-gray-300 hover:bg-gray-50"
                        >
                            Voir
                        </a>

                    </div>

                @endforeach

            </div>



            {{-- =================================================
                 VOIR TOUS
            ================================================== --}}

            @if ($total > 5)

                <div class="mt-5 border-t border-gray-100 pt-4">

                    <a
                        href="{{ route('authors.following') }}"
                        class="flex items-center justify-between text-sm font-semibold text-gray-700 transition hover:text-gray-900"
                    >

                        <span>
                            Voir tous mes abonnements
                        </span>

                        <span>
                            →
                        </span>

                    </a>

                </div>

            @endif

        @endif

    </div>

</section>