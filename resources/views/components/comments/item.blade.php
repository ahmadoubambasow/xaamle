@props(['comment'])

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


                <p
                    data-comment-text
                    class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-700"
                >
                    {{ $comment->content }}
                </p>


                <div class="mt-3 flex items-center gap-4">

                    @auth

                        <button
                            type="button"
                            data-action="reply"
                            class="text-sm font-medium text-gray-500 transition hover:text-gray-900"
                        >
                            ↩ Répondre
                        </button>

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-500"
                        >
                            Connectez-vous pour répondre
                        </a>

                    @endauth


                    @if($comment->replies->count())

                        <button
                            type="button"
                            data-action="toggle-replies"
                            class="text-sm font-medium text-gray-500 transition hover:text-gray-900"
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