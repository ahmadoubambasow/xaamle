<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Mes publications
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Gérez les contenus que vous partagez avec la communauté.
                </p>
            </div>

            <a
                href="{{ route('posts.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800"
            >
                <span class="mr-2 text-lg">+</span>
                Nouvelle publication
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-10">

        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- Message de succès --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4">
                    <div class="flex items-center gap-3">
                        <span class="text-green-600">✓</span>

                        <p class="text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif


            @if ($posts->count())

                {{-- Statistiques rapides --}}
                <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-sm text-gray-500">
                            Total
                        </p>

                        <p class="mt-1 text-2xl font-bold text-gray-900">
                            {{ $posts->total() }}
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            Publication(s)
                        </p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-sm text-gray-500">
                            Publiées
                        </p>

                        <p class="mt-1 text-2xl font-bold text-gray-900">
                            {{ $posts->where('status', 'published')->count() }}
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            Sur cette page
                        </p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-sm text-gray-500">
                            Brouillons
                        </p>

                        <p class="mt-1 text-2xl font-bold text-gray-900">
                            {{ $posts->where('status', 'draft')->count() }}
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            Sur cette page
                        </p>
                    </div>

                </div>


                {{-- Liste --}}
                <div class="space-y-5">

                    @foreach ($posts as $post)

                        <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md">

                            <div class="flex flex-col md:flex-row">

                                {{-- Couverture --}}
                                @if ($post->cover_image)

                                    <div class="h-56 w-full shrink-0 md:h-auto md:w-56">
                                        <img
                                            src="{{ asset('storage/' . $post->cover_image) }}"
                                            alt="{{ $post->title }}"
                                            class="h-full w-full object-cover"
                                        >
                                    </div>

                                @else

                                    <div class="flex h-40 w-full shrink-0 items-center justify-center bg-gray-100 md:h-auto md:w-56">
                                        <span class="text-4xl text-gray-300">
                                            📝
                                        </span>
                                    </div>

                                @endif


                                {{-- Contenu --}}
                                <div class="flex flex-1 flex-col p-6">

                                    <div class="flex flex-wrap items-start justify-between gap-3">

                                        <div class="flex-1">

                                            <div class="mb-3">
                                                @if ($post->status === 'published')

                                                    <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                                        Publié
                                                    </span>

                                                @else

                                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-yellow-500"></span>
                                                        Brouillon
                                                    </span>

                                                @endif
                                            </div>


                                            <h3 class="text-xl font-bold leading-tight text-gray-900">
                                                {{ $post->title }}
                                            </h3>

                                            @if ($post->excerpt)

                                                <p class="mt-3 line-clamp-2 text-sm leading-6 text-gray-500">
                                                    {{ $post->excerpt }}
                                                </p>

                                            @endif

                                        </div>

                                    </div>


                                    {{-- Informations --}}
                                    <div class="mt-5 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-gray-400">

                                        <span>
                                            Créé le
                                            {{ $post->created_at->translatedFormat('d F Y') }}
                                        </span>

                                        @if ($post->published_at)

                                            <span>
                                                Publié le
                                                {{ $post->published_at->translatedFormat('d F Y') }}
                                            </span>

                                        @endif

                                    </div>


                                    {{-- Actions --}}
                                    <div class="mt-6 flex flex-wrap items-center gap-2 border-t border-gray-100 pt-5">

                                        <a
                                            href="{{ route('public.posts.show', $post) }}"
                                            class="inline-flex items-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800"
                                        >
                                            Voir
                                        </a>

                                        <a
                                            href="{{ route('posts.edit', $post) }}"
                                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                                        >
                                            Modifier
                                        </a>


                                        <x-confirm-delete
                                            title="Supprimer cette publication ?"
                                            message="Cette action est définitive. La publication « {{ $post->title }} » sera supprimée de façon permanente."
                                            class="ml-auto"
                                        >
                                            <form
                                                action="{{ route('posts.destroy', $post) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="inline-flex w-full justify-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 sm:w-auto"
                                                >
                                                    Supprimer définitivement
                                                </button>
                                            </form>
                                        </x-confirm-delete>

                                    </div>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- Pagination --}}
                @if ($posts->hasPages())

                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>

                @endif


            @else

                {{-- État vide --}}
                <div class="rounded-2xl border border-gray-200 bg-white px-6 py-16 text-center shadow-sm">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                        <span class="text-3xl">
                            ✍️
                        </span>
                    </div>

                    <h3 class="mt-5 text-lg font-semibold text-gray-900">
                        Aucune publication pour le moment
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                        Commencez à partager vos idées, vos connaissances
                        et vos expériences avec la communauté Xaamlé.
                    </p>

                    <a
                        href="{{ route('posts.create') }}"
                        class="mt-6 inline-flex items-center rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                    >
                        Créer ma première publication
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>