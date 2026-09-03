@props(['posts'])

<section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5">

        <div>
            <h2 class="text-base font-semibold text-gray-900">
                Mes dernières publications
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Retrouvez rapidement vos dernières publications.
            </p>
        </div>

        <a
            href="{{ route('posts.index') }}"
            class="hidden text-sm font-semibold text-gray-600 transition hover:text-gray-900 sm:inline"
        >
            Voir tout →
        </a>

    </div>

    <div>

        @forelse ($posts as $post)

            <div class="flex items-center gap-4 border-b border-gray-100 px-6 py-5 last:border-0">

                <div class="min-w-0 flex-1">

                    <h3 class="truncate text-sm font-semibold text-gray-900">
                        {{ $post->title }}
                    </h3>

                    <p class="mt-1 text-xs text-gray-500">
                        {{ $post->created_at->diffForHumans() }}
                    </p>

                </div>

                <div class="hidden shrink-0 items-center gap-4 text-xs text-gray-500 sm:flex">
                    <span>❤️ {{ $post->likes_count }}</span>
                    <span>💬 {{ $post->comments_count }}</span>
                </div>

                <a
                    href="{{ route('public.posts.show', $post) }}"
                    class="shrink-0 rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    Voir
                </a>

            </div>

        @empty

            <div class="px-6 py-10 text-center">

                <p class="text-sm font-medium text-gray-900">
                    Vous n'avez encore publié aucun article.
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Partagez votre première idée avec la communauté.
                </p>

                <a
                    href="{{ route('posts.create') }}"
                    class="mt-4 inline-flex items-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                >
                    Écrire ma première publication
                </a>

            </div>

        @endforelse

    </div>

</section>