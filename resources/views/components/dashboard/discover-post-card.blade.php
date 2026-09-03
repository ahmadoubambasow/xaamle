@props(['post'])

<article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">

    @if ($post->cover_image)

        <div class="aspect-[16/9] overflow-hidden bg-gray-100">

            <img
                src="{{ asset('storage/' . $post->cover_image) }}"
                alt="{{ $post->title }}"
                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
            >

        </div>

    @endif

    <div class="p-5">

        <div class="flex items-center gap-2">

            <div class="h-7 w-7 shrink-0 overflow-hidden rounded-full">

                @if ($post->user->avatar)

                    <img
                        src="{{ asset('storage/' . $post->user->avatar) }}"
                        alt="{{ $post->user->name }}"
                        class="h-full w-full object-cover"
                    >

                @else

                    <div class="flex h-full w-full items-center justify-center bg-gray-900 text-[10px] font-semibold text-white">
                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                    </div>

                @endif

            </div>

            <span class="truncate text-xs font-medium text-gray-500">
                {{ $post->user->name }}
            </span>

        </div>

        <h3 class="mt-4 line-clamp-2 text-base font-semibold text-gray-900">
            {{ $post->title }}
        </h3>

        @if ($post->excerpt)

            <p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-500">
                {{ $post->excerpt }}
            </p>

        @endif

        <div class="mt-4 flex items-center justify-between">

            <div class="flex items-center gap-3 text-xs text-gray-500">
                <span>❤️ {{ $post->likes_count }}</span>
                <span>💬 {{ $post->comments_count }}</span>
            </div>

            <a
                href="{{ route('public.posts.show', $post) }}"
                class="text-xs font-semibold text-gray-700 transition hover:text-gray-900"
            >
                Lire →
            </a>

        </div>

    </div>

</article>