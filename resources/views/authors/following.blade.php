<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-gray-900">
                Mes abonnements
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Les auteurs dont vous suivez les publications.
            </p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8 sm:py-10">

        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- En-tête de section --}}
            <div class="mb-6 flex items-center justify-between">

                <div>
                    <h1 class="text-lg font-semibold text-gray-900">
                        Comptes suivis
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $following->total() }}
                        {{ $following->total() > 1 ? 'auteurs suivis' : 'auteur suivi' }}
                    </p>
                </div>

                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                >
                    ← Tableau de bord
                </a>

            </div>


            @if ($following->isEmpty())

                {{-- État vide --}}
                <section class="rounded-2xl border border-gray-200 bg-white px-6 py-12 text-center shadow-sm">

                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 text-xl"
                    >
                        👤
                    </div>

                    <h2 class="mt-4 text-base font-semibold text-gray-900">
                        Aucun abonnement
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                        Vous ne suivez encore aucun auteur.
                        Découvrez les publications de la communauté et commencez à suivre vos auteurs préférés.
                    </p>

                    <a
                        href="{{ route('home') }}"
                        class="mt-5 inline-flex items-center rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                    >
                        Découvrir les publications
                    </a>

                </section>

            @else

                {{-- Liste des abonnements --}}
                <div class="grid gap-5 sm:grid-cols-2">

                    @foreach ($following as $follow)

                        @php
                            $author = $follow->author;
                        @endphp

                        <article
                            class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md"
                        >

                            <div class="flex items-start gap-4">

                                {{-- Avatar --}}
                                <a
                                    href="{{ route('authors.show', $author) }}"
                                    class="h-12 w-12 shrink-0 overflow-hidden rounded-full"
                                >

                                    @if ($author->avatar)

                                        <img
                                            src="{{ asset('storage/' . $author->avatar) }}"
                                            alt="Photo de {{ $author->name }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <div
                                            class="flex h-full w-full items-center justify-center bg-gray-900 text-sm font-semibold text-white"
                                        >
                                            {{ strtoupper(substr($author->name, 0, 1)) }}
                                        </div>

                                    @endif

                                </a>


                                {{-- Informations --}}
                                <div class="min-w-0 flex-1">

                                    <a
                                        href="{{ route('authors.show', $author) }}"
                                        class="block truncate text-base font-semibold text-gray-900 transition hover:text-gray-600"
                                    >
                                        {{ $author->name }}
                                    </a>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $author->posts_count }}
                                        {{ $author->posts_count > 1 ? 'publications' : 'publication' }}

                                        <span class="mx-1 text-gray-300">
                                            •
                                        </span>

                                        {{ $author->followers_count }}
                                        {{ $author->followers_count > 1 ? 'abonnés' : 'abonné' }}
                                    </p>

                                </div>

                            </div>


                            {{-- Actions --}}
                            <div class="mt-5 flex items-center gap-2 border-t border-gray-100 pt-4">

                                <a
                                    href="{{ route('authors.show', $author) }}"
                                    class="flex-1 rounded-xl border border-gray-200 px-4 py-2 text-center text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                                >
                                    Voir le profil
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('authors.follow.toggle', $author) }}"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="rounded-xl px-4 py-2 text-sm font-semibold text-gray-500 transition hover:bg-red-50 hover:text-red-600"
                                    >
                                        Ne plus suivre
                                    </button>
                                </form>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- Pagination --}}
                @if ($following->hasPages())

                    <div class="mt-8">
                        {{ $following->links() }}
                    </div>

                @endif

            @endif

        </div>

    </div>

</x-app-layout>