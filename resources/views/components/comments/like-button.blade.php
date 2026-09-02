@props(['comment'])

@auth

    @php
        $liked = $comment->likes->contains(
            'user_id',
            auth()->id()
        );
    @endphp

    <div class="relative inline-flex items-center">

        <button
            type="button"
            data-action="like"
            data-like-url="{{ route('comments.likes.toggle', $comment) }}"
            data-liked="{{ $liked ? 'true' : 'false' }}"
            aria-pressed="{{ $liked ? 'true' : 'false' }}"
            class="group inline-flex items-center gap-1.5 rounded-lg px-2 py-1.5 text-sm font-medium transition
                {{ $liked
                    ? 'text-red-600 hover:bg-red-50'
                    : 'text-gray-500 hover:bg-gray-100 hover:text-red-600'
                }}"
        >

            {{-- Coeur --}}
            <svg
                data-like-icon
                class="h-4 w-4 transition-transform duration-200 group-active:scale-75"
                viewBox="0 0 24 24"
                fill="{{ $liked ? 'currentColor' : 'none' }}"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z"
                />
            </svg>

            <span>
                J'aime
            </span>

            <span
                data-like-count
                class="min-w-[1rem] text-center"
            >
                {{ $comment->likes->count() }}
            </span>

        </button>

        <span
            data-like-error
            class="absolute left-0 top-full z-10 mt-1 hidden whitespace-nowrap text-xs text-red-500"
        ></span>

    </div>

@endauth