@props(['post'])

<article
    class="flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md"
>

    {{-- Image de couverture --}}
    @if ($post->cover_image)

        <a href="{{ route('public.posts.show', $post) }}">
            <div class="aspect-[16/9] overflow-hidden bg-gray-100">

                @if ($post->cover_image)

                    <x-cloudinary::image
                        public-id="{{ $post->cover_image }}"
                        alt="{{ $post->title }}"
                        class="h-full w-full object-cover transition duration-300 hover:scale-105"
                    />

                @endif

            </div>
        </a>

    @endif


    {{-- Contenu --}}
    <div class="flex flex-1 flex-col p-5">

        {{-- Texte --}}
        <div class="flex-1">

            <a
                href="{{ route('public.posts.show', $post) }}"
                class="group"
            >

                <h3 class="line-clamp-2 text-lg font-semibold text-gray-900 transition group-hover:text-gray-600">
                    {{ $post->title }}
                </h3>

            </a>

            @if ($post->excerpt)

                <p class="mt-2 line-clamp-3 text-sm leading-6 text-gray-500">
                    {{ $post->excerpt }}
                </p>

            @endif

        </div>


        {{-- Métadonnées --}}
        <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">

            <p class="text-xs text-gray-400">
                {{ optional($post->published_at)->format('d M Y') }}
            </p>

            <div class="flex items-center gap-3 text-xs text-gray-400">

                <span>
                    ♥ {{ $post->likes_count }}
                </span>

                <span>
                    💬 {{ $post->comments_count }}
                </span>

            </div>

        </div>

    </div>

</article>