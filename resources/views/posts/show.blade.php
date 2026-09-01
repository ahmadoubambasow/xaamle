<x-layouts.public>

    <main class="min-h-screen bg-gray-50 py-10">

        <article class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Retour --}}
            <div class="mb-6 sm:hidden">
                <a
                    href="{{ route('posts.index') }}"
                    class="text-sm font-medium text-gray-600 hover:text-gray-900"
                >
                    ← Mes publications
                </a>
            </div>


            {{-- En-tête de l'article --}}
            <header class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                @if ($post->cover_image)

                    <div class="h-64 w-full sm:h-80 lg:h-96">
                        <img
                            src="{{ asset('storage/' . $post->cover_image) }}"
                            alt="{{ $post->title }}"
                            class="h-full w-full object-cover"
                        >
                    </div>

                @endif


                <div class="px-6 py-8 sm:px-10">

                    {{-- Statut --}}
                    <div class="mb-5">

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


                    {{-- Titre --}}
                    <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900 sm:text-4xl">
                        {{ $post->title }}
                    </h1>


                    {{-- Résumé --}}
                    @if ($post->excerpt)

                        <p class="mt-5 text-lg leading-8 text-gray-500">
                            {{ $post->excerpt }}
                        </p>

                    @endif


                    {{-- Auteur + date --}}
                    <div class="mt-7 flex flex-wrap items-center gap-x-4 gap-y-2 border-t border-gray-100 pt-5">

                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white">
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $post->user->name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                @if ($post->published_at)
                                    Publié le {{ $post->published_at->translatedFormat('d F Y') }}
                                @else
                                    Créé le {{ $post->created_at->translatedFormat('d F Y') }}
                                @endif
                            </p>
                        </div>

                    </div>

                </div>

            </header>


            {{-- Contenu --}}
            <section class="mt-6 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="px-6 py-8 sm:px-10 sm:py-10">

                    <div class="prose prose-gray max-w-none text-gray-700">

                        {!! nl2br(e($post->content)) !!}

                    </div>

                </div>

            </section>


            {{-- Actions --}}
            @can('update', $post)

                <div class="mt-6 flex flex-wrap items-center gap-3">

                    <a
                        href="{{ route('posts.edit', $post) }}"
                        class="inline-flex items-center rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
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

            @endcan


            {{-- Partage --}}
            @if ($post->status === 'published')

                <div class="mt-10 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <h3 class="font-semibold text-gray-900">
                                Partager cette publication
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Faites découvrir ce contenu à votre communauté.
                            </p>
                        </div>

                        <button
                            type="button"
                            id="copy-link"
                            data-url="{{ route('posts.show', $post) }}"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                        >
                            Copier le lien
                        </button>

                    </div>

                </div>

            @endif

        </article>

    </main>


    {{-- Copie du lien --}}
    @if ($post->status === 'published')

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const button = document.getElementById('copy-link');

                if (!button) {
                    return;
                }

                button.addEventListener('click', async function () {

                    const url = this.dataset.url;

                    try {

                        await navigator.clipboard.writeText(url);

                        const originalText = this.textContent;

                        this.textContent = 'Lien copié ✓';

                        setTimeout(() => {
                            this.textContent = originalText;
                        }, 2000);

                    } catch (error) {

                        alert('Impossible de copier le lien.');

                    }

                });

            });
        </script>

    @endif

</x-layouts.public>