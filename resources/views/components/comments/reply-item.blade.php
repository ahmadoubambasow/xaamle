@props(['reply'])

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


                <p
                    data-comment-text
                    class="mt-1 whitespace-pre-line text-sm leading-6 text-gray-600"
                >
                    {{ $reply->content }}
                </p>

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