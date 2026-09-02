@props(['reply'])

@php
    $isLiked = auth()->check()
        && $reply->likes->contains('user_id', auth()->id());

    $likesCount = $reply->likes->count();
@endphp

<article
    data-comment-id="{{ $reply->id }}"
    data-reply-id="{{ $reply->id }}"
    data-update-url="{{ route('comments.update', $reply) }}"
    data-delete-url="{{ route('comments.destroy', $reply) }}"
    class="reply-item"
>

    <div class="flex items-start gap-3">

        {{-- Avatar --}}
        <div
            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-100 text-xs font-semibold text-gray-600"
        >
            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
        </div>


        <div class="min-w-0 flex-1">

            {{-- Affichage --}}
            <div data-comment-display>

                <div class="flex items-start justify-between gap-3">

                    <div>

                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1">

                            <span class="text-sm font-semibold text-gray-900">
                                {{ $reply->user->name }}
                            </span>

                            <span class="text-xs text-gray-400">
                                {{ $reply->created_at->diffForHumans() }}
                            </span>

                        </div>

                    </div>


                    {{-- Actions propriétaire --}}
                    @auth

                        @if(auth()->id() === $reply->user_id)

                            <div class="flex items-center gap-1">

                                <button
                                    type="button"
                                    data-action="edit"
                                    class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
                                    title="Modifier"
                                >
                                    ✏️
                                </button>

                                <button
                                    type="button"
                                    data-action="delete"
                                    class="rounded-lg p-1.5 text-gray-400 transition hover:bg-red-50 hover:text-red-600"
                                    title="Supprimer"
                                >
                                    🗑️
                                </button>

                            </div>

                        @endif

                    @endauth

                </div>


                {{-- Contenu --}}
                <p
                    data-comment-text
                    class="mt-1 whitespace-pre-line text-sm leading-6 text-gray-600"
                >
                    {{ $reply->content }}
                </p>


                {{-- Actions --}}
                @auth

                    <div class="mt-2 flex items-center gap-2">

                        {{-- Like --}}
                        <div class="relative inline-flex items-center">

                            <button
                                type="button"
                                data-action="like"
                                data-like-url="{{ route('comments.likes.toggle', $reply) }}"
                                data-liked="{{ $isLiked ? 'true' : 'false' }}"
                                aria-pressed="{{ $isLiked ? 'true' : 'false' }}"
                                class="group inline-flex items-center gap-1.5 rounded-lg px-2 py-1.5 text-sm font-medium transition
                                    {{ $isLiked
                                        ? 'text-red-600 hover:bg-red-50'
                                        : 'text-gray-500 hover:bg-gray-100 hover:text-red-600'
                                    }}"
                            >

                                {{-- Coeur --}}
                                <svg
                                    data-like-icon
                                    class="h-4 w-4 transition-transform duration-200 group-active:scale-75"
                                    viewBox="0 0 24 24"
                                    fill="{{ $isLiked ? 'currentColor' : 'none' }}"
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
                                    {{ $likesCount }}
                                </span>

                            </button>


                            {{-- Erreur --}}
                            <span
                                data-like-error
                                class="absolute left-0 top-full z-10 mt-1 hidden whitespace-nowrap text-xs text-red-500"
                            ></span>

                        </div>

                    </div>

                @endauth

            </div>


            {{-- Edition --}}
            @auth

                @if(auth()->id() === $reply->user_id)

                    <x-comments.edit-form
                        :content="$reply->content"
                    />

                    <x-comments.delete-confirmation
                        message="Supprimer cette réponse ?"
                    />

                @endif

            @endauth

        </div>

    </div>

</article>