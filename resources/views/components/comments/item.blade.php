@props(['comment'])

@php
    $isLiked = auth()->check()
        && $comment->likes->contains('user_id', auth()->id());

    $likesCount = $comment->likes->count();
@endphp

<article
    data-comment-id="{{ $comment->id }}"
    data-update-url="{{ route('comments.update', $comment) }}"
    data-delete-url="{{ route('comments.destroy', $comment) }}"
    data-reply-url="{{ route('comments.replies.store', $comment) }}"
    class="comment-item px-6 py-5"
>

    <div class="flex items-start gap-3">

        {{-- Avatar --}}
        <div
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100 text-sm font-semibold text-gray-600"
        >
            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
        </div>


        <div class="min-w-0 flex-1">

            {{-- Commentaire --}}
            <div data-comment-display>

                <div class="flex items-start justify-between gap-3">

                    <div>

                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1">

                            <span class="text-sm font-semibold text-gray-900">
                                {{ $comment->user->name }}
                            </span>

                            <span class="text-xs text-gray-400">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>

                        </div>

                    </div>


                    {{-- Actions propriétaire --}}
                    @auth

                        @if(auth()->id() === $comment->user_id)

                            <div class="flex shrink-0 items-center gap-1">

                                <button
                                    type="button"
                                    data-action="edit"
                                    class="rounded-lg p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
                                    title="Modifier"
                                >
                                    ✏️
                                </button>

                                <button
                                    type="button"
                                    data-action="delete"
                                    class="rounded-lg p-2 text-gray-400 transition hover:bg-red-50 hover:text-red-600"
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
                    class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-700"
                >
                    {{ $comment->content }}
                </p>


                {{-- Actions du commentaire --}}
                <div class="mt-3 flex flex-wrap items-center gap-2">

                    {{-- Like --}}
                    @auth

                        <div class="relative inline-flex items-center">

                            <button
                                type="button"
                                data-action="like"
                                data-like-url="{{ route('comments.likes.toggle', $comment) }}"
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

                            {{-- Message d'erreur --}}
                            <span
                                data-like-error
                                class="absolute left-0 top-full z-10 mt-1 hidden whitespace-nowrap text-xs text-red-500"
                            ></span>

                        </div>

                    @endauth


                    {{-- Répondre --}}
                    @auth

                        <button
                            type="button"
                            data-action="reply"
                            class="rounded-lg px-2 py-1.5 text-sm font-medium text-gray-500 transition hover:bg-gray-100 hover:text-gray-900"
                        >
                            ↩ Répondre
                        </button>

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="rounded-lg px-2 py-1.5 text-sm font-medium text-gray-500 transition hover:bg-gray-100 hover:text-gray-900"
                        >
                            Connectez-vous pour répondre
                        </a>

                    @endauth


                    {{-- Réponses --}}
                    @if($comment->replies->count())

                        <button
                            type="button"
                            data-action="toggle-replies"
                            class="rounded-lg px-2 py-1.5 text-sm font-medium text-gray-500 transition hover:bg-gray-100 hover:text-gray-900"
                        >
                            <span data-replies-count>
                                {{ $comment->replies->count() }}
                            </span>

                            <span data-replies-label>
                                {{ $comment->replies->count() > 1
                                    ? 'réponses'
                                    : 'réponse'
                                }}
                            </span>
                        </button>

                    @endif

                </div>

            </div>


            {{-- Edition --}}
            @auth

                @if(auth()->id() === $comment->user_id)

                    <x-comments.edit-form
                        :content="$comment->content"
                    />

                    <x-comments.delete-confirmation
                        message="Supprimer ce commentaire ?"
                    />

                @endif

            @endauth


            {{-- Réponse --}}
            @auth

                <x-comments.reply-form
                    :user-name="$comment->user->name"
                />

            @endauth


            {{-- Réponses --}}
            @if($comment->replies->count())

                <div
                    data-replies-container
                    class="mt-4 hidden space-y-4 border-l-2 border-gray-100 pl-4"
                >

                    @foreach($comment->replies as $reply)

                        <x-comments.reply-item
                            :reply="$reply"
                        />

                    @endforeach

                </div>

            @endif

        </div>

    </div>

</article>