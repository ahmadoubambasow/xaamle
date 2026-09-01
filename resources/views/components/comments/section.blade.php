@props(['post'])

<section
    id="comments"
    class="mt-6 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm"
>

    {{-- =========================================================
         EN-TÊTE / OUVERTURE
    ========================================================== --}}

    <button
        type="button"
        id="comments-toggle"
        aria-expanded="false"
        aria-controls="comments-content"
        class="flex w-full items-center justify-between px-6 py-5 text-left transition hover:bg-gray-50"
    >
        <div>
            <h2 class="text-lg font-semibold text-gray-900">
                Commentaires
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                <span id="comments-count">
                    {{ $post->comments->count() }}
                </span>

                <span id="comments-label">
                    {{ $post->comments->count() > 1
                        ? 'commentaires'
                        : 'commentaire'
                    }}
                </span>
            </p>
        </div>

        <span
            id="comments-toggle-icon"
            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-600 transition-transform duration-300"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m19 9-7 7-7-7"
                />
            </svg>
        </span>
    </button>


    {{-- =========================================================
         CONTENU REPLIABLE
    ========================================================== --}}

    <div
        id="comments-content"
        class="grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-in-out"
    >
        <div class="min-h-0 overflow-hidden">


            {{-- =================================================
                 FORMULAIRE DE COMMENTAIRE
            ================================================== --}}

            @auth

                <div class="border-b border-gray-100 px-6 py-5">

                    <form
                        id="comment-form"
                        method="POST"
                        action="{{ route('comments.store', $post) }}"
                    >
                        @csrf

                        <div class="flex gap-3">

                            {{-- Avatar --}}
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-900 text-xs font-semibold text-white"
                            >
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>

                            <div class="min-w-0 flex-1">

                                <textarea
                                    id="comment-content"
                                    name="content"
                                    rows="3"
                                    maxlength="1000"
                                    placeholder="Écrivez un commentaire..."
                                    class="block w-full resize-none rounded-xl border-gray-300 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900"
                                ></textarea>

                                <div
                                    id="comment-error"
                                    class="mt-2 hidden rounded-lg bg-red-50 px-3 py-2 text-sm text-red-600"
                                ></div>

                                <div class="mt-3 flex items-center justify-between">

                                    <span class="text-xs text-gray-400">
                                        1000 caractères maximum
                                    </span>

                                    <button
                                        type="submit"
                                        id="comment-submit"
                                        class="inline-flex items-center rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        <span id="comment-submit-text">
                                            Commenter
                                        </span>
                                    </button>

                                </div>

                            </div>
                        </div>

                    </form>

                </div>

            @else

                {{-- =================================================
                     VISITEUR
                ================================================== --}}

                <div class="border-b border-gray-100 px-6 py-5">

                    <div class="rounded-xl bg-gray-50 p-5 text-center">

                        <div
                            class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-gray-200"
                        >
                            💬
                        </div>

                        <p class="mt-3 text-sm font-medium text-gray-900">
                            Participez à la discussion
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Connectez-vous pour laisser un commentaire.
                        </p>

                        <a
                            href="{{ route('login') }}"
                            class="mt-4 inline-flex items-center rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800"
                        >
                            Se connecter
                        </a>

                    </div>

                </div>

            @endauth


            {{-- =================================================
                 LISTE DES COMMENTAIRES
            ================================================== --}}

            <div
                id="comments-list"
                class="divide-y divide-gray-100"
            >

                @forelse($post->comments as $comment)

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

                                {{-- =================================================
                                     AFFICHAGE DU COMMENTAIRE
                                ================================================== --}}

                                <div data-comment-display>

                                    <div class="flex items-start justify-between gap-3">

                                        <div class="min-w-0">

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
                                                        <svg
                                                            class="h-4 w-4"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.5-9.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 8.5-8.5z"
                                                            />
                                                        </svg>
                                                    </button>

                                                    <button
                                                        type="button"
                                                        data-action="delete"
                                                        class="rounded-lg p-2 text-gray-400 transition hover:bg-red-50 hover:text-red-600"
                                                        title="Supprimer"
                                                    >
                                                        <svg
                                                            class="h-4 w-4"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6V7m-9 0h14m-8-3h4a1 1 0 0 1 1 1v2H9V5a1 1 0 0 1 1-1z"
                                                            />
                                                        </svg>
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


                                    {{-- Actions --}}
                                    <div class="mt-3 flex items-center gap-4">

                                        @auth

                                            <button
                                                type="button"
                                                data-action="reply"
                                                class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 transition hover:text-gray-900"
                                            >
                                                <svg
                                                    class="h-4 w-4"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 10h10a4 4 0 0 1 4 4v1m0 0-3-3m3 3-3 3"
                                                    />
                                                </svg>

                                                Répondre
                                            </button>

                                        @else

                                            <a
                                                href="{{ route('login') }}"
                                                class="text-sm font-medium text-gray-500 transition hover:text-gray-900"
                                            >
                                                Connectez-vous pour répondre
                                            </a>

                                        @endauth


                                        @if($comment->replies->count() > 0)

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


                                {{-- =================================================
                                     FORMULAIRE DE MODIFICATION
                                ================================================== --}}

                                @auth

                                    @if(auth()->id() === $comment->user_id)

                                        <div
                                            data-comment-edit
                                            class="hidden"
                                        >

                                            <textarea
                                                data-edit-input
                                                maxlength="1000"
                                                rows="3"
                                                class="block w-full resize-none rounded-xl border-gray-300 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900"
                                            >{{ $comment->content }}</textarea>

                                            <div
                                                data-edit-error
                                                class="mt-2 hidden rounded-lg bg-red-50 px-3 py-2 text-sm text-red-600"
                                            ></div>

                                            <div class="mt-3 flex justify-end gap-2">

                                                <button
                                                    type="button"
                                                    data-action="cancel-edit"
                                                    class="rounded-xl px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100"
                                                >
                                                    Annuler
                                                </button>

                                                <button
                                                    type="button"
                                                    data-action="save-edit"
                                                    class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
                                                >
                                                    <span data-save-text>
                                                        Enregistrer
                                                    </span>
                                                </button>

                                            </div>

                                        </div>

                                    @endif

                                @endauth


                                {{-- =================================================
                                     CONFIRMATION SUPPRESSION
                                ================================================== --}}

                                @auth

                                    @if(auth()->id() === $comment->user_id)

                                        <div
                                            data-delete-confirm
                                            class="mt-3 hidden rounded-xl border border-red-100 bg-red-50 p-4"
                                        >

                                            <p class="text-sm font-medium text-gray-900">
                                                Supprimer ce commentaire ?
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                Cette action est irréversible.
                                            </p>

                                            <div
                                                data-delete-error
                                                class="mt-2 hidden text-sm text-red-600"
                                            ></div>

                                            <div class="mt-3 flex justify-end gap-2">

                                                <button
                                                    type="button"
                                                    data-action="cancel-delete"
                                                    class="rounded-xl px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-white"
                                                >
                                                    Annuler
                                                </button>

                                                <button
                                                    type="button"
                                                    data-action="confirm-delete"
                                                    class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                                                >
                                                    <span data-delete-text>
                                                        Supprimer
                                                    </span>
                                                </button>

                                            </div>

                                        </div>

                                    @endif

                                @endauth


                                {{-- =================================================
                                     FORMULAIRE DE RÉPONSE
                                ================================================== --}}

                                @auth

                                    <div
                                        data-reply-form
                                        class="mt-4 hidden"
                                    >

                                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                                            <div class="mb-3 flex items-center gap-2">

                                                <div
                                                    class="flex h-7 w-7 items-center justify-center rounded-full bg-gray-900 text-[10px] font-semibold text-white"
                                                >
                                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                                </div>

                                                <span class="text-xs font-medium text-gray-500">
                                                    Répondre à {{ $comment->user->name }}
                                                </span>

                                            </div>

                                            <textarea
                                                data-reply-input
                                                rows="3"
                                                maxlength="1000"
                                                placeholder="Écrivez votre réponse..."
                                                class="block w-full resize-none rounded-xl border-gray-300 bg-white text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900"
                                            ></textarea>

                                            <div
                                                data-reply-error
                                                class="mt-2 hidden rounded-lg bg-red-50 px-3 py-2 text-sm text-red-600"
                                            ></div>

                                            <div class="mt-3 flex items-center justify-between">

                                                <span
                                                    data-reply-counter
                                                    class="text-xs text-gray-400"
                                                >
                                                    0 / 1000
                                                </span>

                                                <div class="flex items-center gap-2">

                                                    <button
                                                        type="button"
                                                        data-action="cancel-reply"
                                                        class="rounded-xl px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100"
                                                    >
                                                        Annuler
                                                    </button>

                                                    <button
                                                        type="button"
                                                        data-action="submit-reply"
                                                        class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
                                                        disabled
                                                    >
                                                        <span data-reply-submit-text>
                                                            Répondre
                                                        </span>
                                                    </button>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                @endauth


                                {{-- =================================================
                                     RÉPONSES
                                ================================================== --}}

                                @if($comment->replies->count() > 0)

                                    <div
                                        data-replies-container
                                        class="mt-4 hidden space-y-4 border-l-2 border-gray-100 pl-4"
                                    >

                                        @foreach($comment->replies as $reply)

                                            <article
                                                data-reply-id="{{ $reply->id }}"
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


                                                            {{-- Actions réponse --}}
                                                            @auth

                                                                @if(auth()->id() === $reply->user_id)

                                                                    <div class="flex shrink-0 items-center gap-1">

                                                                        <button
                                                                            type="button"
                                                                            class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
                                                                            title="Modifier"
                                                                        >
                                                                            <svg
                                                                                class="h-3.5 w-3.5"
                                                                                fill="none"
                                                                                viewBox="0 0 24 24"
                                                                                stroke="currentColor"
                                                                            >
                                                                                <path
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.5-9.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 8.5-8.5z"
                                                                                />
                                                                            </svg>
                                                                        </button>

                                                                        <button
                                                                            type="button"
                                                                            class="rounded-lg p-1.5 text-gray-400 transition hover:bg-red-50 hover:text-red-600"
                                                                            title="Supprimer"
                                                                        >
                                                                            <svg
                                                                                class="h-3.5 w-3.5"
                                                                                fill="none"
                                                                                viewBox="0 0 24 24"
                                                                                stroke="currentColor"
                                                                            >
                                                                                <path
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6V7m-9 0h14"
                                                                                />
                                                                            </svg>
                                                                        </button>

                                                                    </div>

                                                                @endif

                                                            @endauth

                                                        </div>


                                                        <p class="mt-1 whitespace-pre-line text-sm leading-6 text-gray-600">
                                                            {{ $reply->content }}
                                                        </p>

                                                    </div>

                                                </div>

                                            </article>

                                        @endforeach

                                    </div>

                                @endif

                            </div>

                        </div>

                    </article>

                @empty

                    <div
                        data-comments-empty
                        class="px-6 py-10 text-center"
                    >

                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100"
                        >
                            💬
                        </div>

                        <p class="mt-3 text-sm font-medium text-gray-900">
                            Aucun commentaire
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Soyez le premier à participer à la discussion.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>
    </div>

</section>


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', () => {

    const commentsSection = document.getElementById('comments');

    if (!commentsSection) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | CSRF
    |--------------------------------------------------------------------------
    */

    @auth

        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content');

        if (!csrfToken) {
            console.error('Token CSRF introuvable.');
            return;
        }

    @endauth


    /*
    |--------------------------------------------------------------------------
    | Ouverture / fermeture des commentaires
    |--------------------------------------------------------------------------
    */

    const toggle =
        commentsSection.querySelector('#comments-toggle');

    const content =
        commentsSection.querySelector('#comments-content');

    const icon =
        commentsSection.querySelector('#comments-toggle-icon');


    if (toggle && content && icon) {

        toggle.addEventListener('click', () => {

            const isOpen =
                toggle.getAttribute('aria-expanded') === 'true';

            if (isOpen) {

                toggle.setAttribute(
                    'aria-expanded',
                    'false'
                );

                content.classList.remove(
                    'grid-rows-[1fr]'
                );

                content.classList.add(
                    'grid-rows-[0fr]'
                );

                icon.classList.remove(
                    'rotate-180'
                );

            } else {

                toggle.setAttribute(
                    'aria-expanded',
                    'true'
                );

                content.classList.remove(
                    'grid-rows-[0fr]'
                );

                content.classList.add(
                    'grid-rows-[1fr]'
                );

                icon.classList.add(
                    'rotate-180'
                );

            }

        });

    }


    @auth

        /*
        |--------------------------------------------------------------------------
        | Références
        |--------------------------------------------------------------------------
        */

        const form =
            commentsSection.querySelector('#comment-form');

        const textarea =
            commentsSection.querySelector('#comment-content');

        const submitButton =
            commentsSection.querySelector('#comment-submit');

        const submitText =
            commentsSection.querySelector('#comment-submit-text');

        const errorBox =
            commentsSection.querySelector('#comment-error');

        const commentsList =
            commentsSection.querySelector('#comments-list');

        const commentsCount =
            commentsSection.querySelector('#comments-count');

        const commentsLabel =
            commentsSection.querySelector('#comments-label');


        /*
        |--------------------------------------------------------------------------
        | Création d'un commentaire
        |--------------------------------------------------------------------------
        */

        if (form) {

            form.addEventListener('submit', async (event) => {

                event.preventDefault();

                hideError(errorBox);

                const commentContent =
                    textarea.value.trim();


                if (!commentContent) {

                    showError(
                        errorBox,
                        'Veuillez écrire un commentaire.'
                    );

                    textarea.focus();

                    return;
                }


                if (commentContent.length < 2) {

                    showError(
                        errorBox,
                        'Votre commentaire doit contenir au moins 2 caractères.'
                    );

                    textarea.focus();

                    return;
                }


                setButtonLoading(
                    submitButton,
                    submitText,
                    true,
                    'Publication...'
                );


                try {

                    const response = await fetch(
                        form.action,
                        {
                            method: 'POST',

                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            },

                            body: JSON.stringify({
                                content: commentContent
                            })
                        }
                    );


                    const data =
                        await parseJson(response);


                    if (response.status === 422) {

                        showError(
                            errorBox,
                            data.errors?.content?.[0]
                            ?? 'Le commentaire est invalide.'
                        );

                        return;
                    }


                    if (!response.ok) {

                        throw new Error(
                            data.message
                            ?? 'Impossible d’ajouter le commentaire.'
                        );
                    }


                    addComment(
                        data.comment
                    );


                    updateCommentsCount(
                        data.comments_count
                    );


                    textarea.value = '';

                    textarea.focus();

                } catch (error) {

                    console.error(
                        'Erreur création commentaire :',
                        error
                    );

                    showError(
                        errorBox,
                        error.message
                        ?? 'Impossible d’ajouter le commentaire.'
                    );

                } finally {

                    setButtonLoading(
                        submitButton,
                        submitText,
                        false,
                        'Commenter'
                    );

                }

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Gestion globale des actions
        |--------------------------------------------------------------------------
        */

        commentsList.addEventListener(
            'click',
            async (event) => {

                const button =
                    event.target.closest('button[data-action]');

                if (!button) {
                    return;
                }


                const action =
                    button.dataset.action;


                const article =
                    button.closest('[data-comment-id]');


                if (!article) {
                    return;
                }


                if (action === 'edit') {

                    openEdit(article);

                    return;
                }


                if (action === 'cancel-edit') {

                    closeEdit(article);

                    return;
                }


                if (action === 'save-edit') {

                    await saveEdit(article);

                    return;
                }


                if (action === 'delete') {

                    openDeleteConfirmation(article);

                    return;
                }


                if (action === 'cancel-delete') {

                    closeDeleteConfirmation(article);

                    return;
                }


                if (action === 'confirm-delete') {

                    await deleteComment(article);

                    return;
                }


                if (action === 'reply') {

                    openReplyForm(article);

                    return;
                }


                if (action === 'cancel-reply') {

                    closeReplyForm(article);

                    return;
                }


                if (action === 'submit-reply') {

                    await submitReply(article);

                    return;
                }


                if (action === 'toggle-replies') {

                    toggleReplies(article);

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Gestion du textarea de réponse
        |--------------------------------------------------------------------------
        */

        commentsList.addEventListener(
            'input',
            (event) => {

                if (!event.target.matches('[data-reply-input]')) {
                    return;
                }


                const input =
                    event.target;

                const article =
                    input.closest('[data-comment-id]');

                const counter =
                    article.querySelector('[data-reply-counter]');

                const button =
                    article.querySelector('[data-action="submit-reply"]');


                counter.textContent =
                    `${input.value.length} / 1000`;


                button.disabled =
                    input.value.trim().length < 2;

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Ouvrir formulaire réponse
        |--------------------------------------------------------------------------
        */

        function openReplyForm(article) {

            const form =
                article.querySelector('[data-reply-form]');

            if (!form) {
                return;
            }


            form.classList.remove('hidden');


            const input =
                form.querySelector('[data-reply-input]');

            if (input) {
                input.focus();
            }

        }


        /*
        |--------------------------------------------------------------------------
        | Fermer formulaire réponse
        |--------------------------------------------------------------------------
        */

        function closeReplyForm(article) {

            const form =
                article.querySelector('[data-reply-form]');

            if (!form) {
                return;
            }


            const input =
                form.querySelector('[data-reply-input]');

            const error =
                form.querySelector('[data-reply-error]');

            const counter =
                form.querySelector('[data-reply-counter]');

            const button =
                form.querySelector('[data-action="submit-reply"]');


            input.value = '';

            counter.textContent =
                '0 / 1000';

            button.disabled =
                true;

            hideError(error);

            form.classList.add('hidden');

        }


        /*
        |--------------------------------------------------------------------------
        | Envoyer une réponse
        |--------------------------------------------------------------------------
        */

        async function submitReply(article) {

            const url =
                article.dataset.replyUrl;

            const form =
                article.querySelector('[data-reply-form]');

            const input =
                article.querySelector('[data-reply-input]');

            const error =
                article.querySelector('[data-reply-error]');

            const button =
                article.querySelector('[data-action="submit-reply"]');

            const buttonText =
                article.querySelector('[data-reply-submit-text]');


            if (
                !url ||
                !form ||
                !input ||
                !error ||
                !button ||
                !buttonText
            ) {
                return;
            }


            hideError(error);


            const content =
                input.value.trim();


            if (!content) {

                showError(
                    error,
                    'Veuillez écrire une réponse.'
                );

                input.focus();

                return;
            }


            if (content.length < 2) {

                showError(
                    error,
                    'Votre réponse doit contenir au moins 2 caractères.'
                );

                input.focus();

                return;
            }


            setButtonLoading(
                button,
                buttonText,
                true,
                'Publication...'
            );


            try {

                const response = await fetch(
                    url,
                    {
                        method: 'POST',

                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },

                        body: JSON.stringify({
                            content: content
                        })
                    }
                );


                const data =
                    await parseJson(response);


                if (response.status === 422) {

                    showError(
                        error,
                        data.errors?.content?.[0]
                        ?? 'La réponse est invalide.'
                    );

                    return;
                }


                if (response.status === 403) {

                    showError(
                        error,
                        'Vous n’êtes pas autorisé à répondre.'
                    );

                    return;
                }


                if (!response.ok) {

                    throw new Error(
                        data.message
                        ?? 'Impossible d’ajouter la réponse.'
                    );
                }


                addReply(
                    article,
                    data.reply
                );


                input.value = '';

                const counter =
                    article.querySelector('[data-reply-counter]');

                counter.textContent =
                    '0 / 1000';


                button.disabled =
                    true;


                form.classList.add('hidden');

            } catch (error) {

                console.error(
                    'Erreur création réponse :',
                    error
                );

                showError(
                    error,
                    error.message
                    ?? 'Impossible d’ajouter la réponse.'
                );

            } finally {

                setButtonLoading(
                    button,
                    buttonText,
                    false,
                    'Répondre'
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Ajouter une réponse dans le DOM
        |--------------------------------------------------------------------------
        */

        function addReply(article, reply) {

            let container =
                article.querySelector('[data-replies-container]');


            if (!container) {

                container =
                    document.createElement('div');

                container.dataset.repliesContainer = '';

                container.className =
                    'mt-4 space-y-4 border-l-2 border-gray-100 pl-4';


                const replyForm =
                    article.querySelector('[data-reply-form]');

                replyForm.insertAdjacentElement(
                    'afterend',
                    container
                );


                createRepliesToggle(
                    article
                );

            }


            const replyArticle =
                document.createElement('article');

            replyArticle.dataset.replyId =
                reply.id;

            replyArticle.className =
                'reply-item';


            const initial =
                reply.user.name
                    .charAt(0)
                    .toUpperCase();


            replyArticle.innerHTML = `

                <div class="flex items-start gap-3">

                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-100 text-xs font-semibold text-gray-600"
                    >
                        ${escapeHtml(initial)}
                    </div>

                    <div class="min-w-0 flex-1">

                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1">

                            <span class="text-sm font-semibold text-gray-900">
                                ${escapeHtml(reply.user.name)}
                            </span>

                            <span class="text-xs text-gray-400">
                                ${escapeHtml(reply.created_at)}
                            </span>

                        </div>

                        <p class="mt-1 whitespace-pre-line text-sm leading-6 text-gray-600">
                            ${escapeHtml(reply.content)}
                        </p>

                    </div>

                </div>

            `;


            container.appendChild(
                replyArticle
            );


            container.classList.remove(
                'hidden'
            );


            updateRepliesCount(
                article
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Créer bouton réponses
        |--------------------------------------------------------------------------
        */

        function createRepliesToggle(article) {

            const actions =
                article.querySelector('[data-action="reply"]')
                    ?.parentElement;


            if (!actions) {
                return;
            }


            if (
                actions.querySelector(
                    '[data-action="toggle-replies"]'
                )
            ) {
                return;
            }


            const button =
                document.createElement('button');

            button.type =
                'button';

            button.dataset.action =
                'toggle-replies';

            button.className =
                'text-sm font-medium text-gray-500 transition hover:text-gray-900';

            button.innerHTML = `
                <span data-replies-count>0</span>
                <span data-replies-label>réponse</span>
            `;


            actions.appendChild(
                button
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Afficher / masquer les réponses
        |--------------------------------------------------------------------------
        */

        function toggleReplies(article) {

            const container =
                article.querySelector('[data-replies-container]');

            if (!container) {
                return;
            }


            container.classList.toggle(
                'hidden'
            );


            const button =
                article.querySelector(
                    '[data-action="toggle-replies"]'
                );


            if (!button) {
                return;
            }


            const count =
                article.querySelectorAll(
                    '.reply-item'
                ).length;


            const label =
                button.querySelector(
                    '[data-replies-label]'
                );


            if (container.classList.contains('hidden')) {

                label.textContent =
                    count > 1
                        ? 'réponses'
                        : 'réponse';

            } else {

                label.textContent =
                    'Masquer les réponses';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Compteur réponses
        |--------------------------------------------------------------------------
        */

        function updateRepliesCount(article) {

            const count =
                article.querySelectorAll(
                    '.reply-item'
                ).length;


            const countElement =
                article.querySelector(
                    '[data-replies-count]'
                );

            const label =
                article.querySelector(
                    '[data-replies-label]'
                );


            if (countElement) {

                countElement.textContent =
                    count;

            }


            if (label) {

                label.textContent =
                    count > 1
                        ? 'réponses'
                        : 'réponse';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Modifier commentaire
        |--------------------------------------------------------------------------
        */

        function openEdit(article) {

            const display =
                article.querySelector(
                    '[data-comment-display]'
                );

            const edit =
                article.querySelector(
                    '[data-comment-edit]'
                );

            const input =
                article.querySelector(
                    '[data-edit-input]'
                );


            if (!display || !edit || !input) {
                return;
            }


            display.classList.add(
                'hidden'
            );

            edit.classList.remove(
                'hidden'
            );


            input.focus();

            input.setSelectionRange(
                input.value.length,
                input.value.length
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Annuler modification
        |--------------------------------------------------------------------------
        */

        function closeEdit(article) {

            const display =
                article.querySelector(
                    '[data-comment-display]'
                );

            const edit =
                article.querySelector(
                    '[data-comment-edit]'
                );

            const input =
                article.querySelector(
                    '[data-edit-input]'
                );

            const error =
                article.querySelector(
                    '[data-edit-error]'
                );

            const text =
                article.querySelector(
                    '[data-comment-text]'
                );


            if (!display || !edit || !input) {
                return;
            }


            if (text) {

                input.value =
                    text.textContent.trim();

            }


            hideError(error);

            edit.classList.add(
                'hidden'
            );

            display.classList.remove(
                'hidden'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Enregistrer modification
        |--------------------------------------------------------------------------
        */

        async function saveEdit(article) {

            const url =
                article.dataset.updateUrl;

            const input =
                article.querySelector(
                    '[data-edit-input]'
                );

            const error =
                article.querySelector(
                    '[data-edit-error]'
                );

            const saveButton =
                article.querySelector(
                    '[data-action="save-edit"]'
                );

            const saveText =
                article.querySelector(
                    '[data-save-text]'
                );

            const text =
                article.querySelector(
                    '[data-comment-text]'
                );


            if (
                !url ||
                !input ||
                !error ||
                !saveButton ||
                !saveText ||
                !text
            ) {
                return;
            }


            hideError(error);


            const newContent =
                input.value.trim();


            if (!newContent) {

                showError(
                    error,
                    'Veuillez écrire un commentaire.'
                );

                input.focus();

                return;
            }


            if (newContent.length < 2) {

                showError(
                    error,
                    'Votre commentaire doit contenir au moins 2 caractères.'
                );

                input.focus();

                return;
            }


            setButtonLoading(
                saveButton,
                saveText,
                true,
                'Enregistrement...'
            );


            try {

                const response = await fetch(
                    url,
                    {
                        method: 'PUT',

                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },

                        body: JSON.stringify({
                            content: newContent
                        })
                    }
                );


                const data =
                    await parseJson(response);


                if (response.status === 422) {

                    showError(
                        error,
                        data.errors?.content?.[0]
                        ?? 'Le commentaire est invalide.'
                    );

                    return;
                }


                if (response.status === 403) {

                    showError(
                        error,
                        'Vous n’êtes pas autorisé à modifier ce commentaire.'
                    );

                    return;
                }


                if (!response.ok) {

                    throw new Error(
                        data.message
                        ?? 'Impossible de modifier le commentaire.'
                    );
                }


                text.textContent =
                    data.comment.content;


                closeEdit(article);

            } catch (error) {

                console.error(
                    'Erreur modification commentaire :',
                    error
                );

                showError(
                    article.querySelector('[data-edit-error]'),
                    error.message
                    ?? 'Impossible de modifier le commentaire.'
                );

            } finally {

                setButtonLoading(
                    saveButton,
                    saveText,
                    false,
                    'Enregistrer'
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Confirmation suppression
        |--------------------------------------------------------------------------
        */

        function openDeleteConfirmation(article) {

            const display =
                article.querySelector(
                    '[data-comment-display]'
                );

            const confirmation =
                article.querySelector(
                    '[data-delete-confirm]'
                );


            if (!display || !confirmation) {
                return;
            }


            display.classList.add(
                'hidden'
            );

            confirmation.classList.remove(
                'hidden'
            );

        }


        function closeDeleteConfirmation(article) {

            const display =
                article.querySelector(
                    '[data-comment-display]'
                );

            const confirmation =
                article.querySelector(
                    '[data-delete-confirm]'
                );


            if (!display || !confirmation) {
                return;
            }


            confirmation.classList.add(
                'hidden'
            );

            display.classList.remove(
                'hidden'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Supprimer commentaire
        |--------------------------------------------------------------------------
        */

        async function deleteComment(article) {

            const url =
                article.dataset.deleteUrl;

            const button =
                article.querySelector(
                    '[data-action="confirm-delete"]'
                );

            const buttonText =
                article.querySelector(
                    '[data-delete-text]'
                );

            const error =
                article.querySelector(
                    '[data-delete-error]'
                );


            if (
                !url ||
                !button ||
                !buttonText
            ) {
                return;
            }


            hideError(error);


            setButtonLoading(
                button,
                buttonText,
                true,
                'Suppression...'
            );


            try {

                const response = await fetch(
                    url,
                    {
                        method: 'DELETE',

                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                );


                const data =
                    await parseJson(response);


                if (response.status === 403) {

                    throw new Error(
                        'Vous n’êtes pas autorisé à supprimer ce commentaire.'
                    );

                }


                if (!response.ok) {

                    throw new Error(
                        data.message
                        ?? 'Impossible de supprimer le commentaire.'
                    );

                }


                article.remove();


                updateCommentsCount(
                    data.comments_count
                );


                if (
                    data.comments_count === 0
                    &&
                    !commentsList.querySelector(
                        '[data-comments-empty]'
                    )
                ) {

                    showEmptyState();

                }

            } catch (error) {

                console.error(
                    'Erreur suppression commentaire :',
                    error
                );


                showError(
                    error,
                    error.message
                    ?? 'Impossible de supprimer le commentaire.'
                );

            } finally {

                setButtonLoading(
                    button,
                    buttonText,
                    false,
                    'Supprimer'
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Ajouter commentaire
        |--------------------------------------------------------------------------
        */

        function addComment(comment) {

            const emptyState =
                commentsList.querySelector(
                    '[data-comments-empty]'
                );


            if (emptyState) {
                emptyState.remove();
            }


            const article =
                document.createElement('article');


            article.dataset.commentId =
                comment.id;

            article.dataset.updateUrl =
                `/comments/${comment.id}`;

            article.dataset.deleteUrl =
                `/comments/${comment.id}`;

            article.dataset.replyUrl =
                `/comments/${comment.id}/replies`;

            article.className =
                'comment-item px-6 py-5';


            const initial =
                comment.user.name
                    .charAt(0)
                    .toUpperCase();


            article.innerHTML = `

                <div class="flex items-start gap-3">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100 text-sm font-semibold text-gray-600"
                    >
                        ${escapeHtml(initial)}
                    </div>


                    <div class="min-w-0 flex-1">

                        <div data-comment-display>

                            <div class="flex items-start justify-between gap-3">

                                <div>

                                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1">

                                        <span class="text-sm font-semibold text-gray-900">
                                            ${escapeHtml(comment.user.name)}
                                        </span>

                                        <span class="text-xs text-gray-400">
                                            ${escapeHtml(comment.created_at)}
                                        </span>

                                    </div>

                                </div>


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

                            </div>


                            <p
                                data-comment-text
                                class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-700"
                            >
                                ${escapeHtml(comment.content)}
                            </p>


                            <div class="mt-3 flex items-center gap-4">

                                <button
                                    type="button"
                                    data-action="reply"
                                    class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 transition hover:text-gray-900"
                                >
                                    ↩ Répondre
                                </button>

                            </div>

                        </div>


                        <div
                            data-comment-edit
                            class="hidden"
                        >

                            <textarea
                                data-edit-input
                                maxlength="1000"
                                rows="3"
                                class="block w-full resize-none rounded-xl border-gray-300 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900"
                            >${escapeHtml(comment.content)}</textarea>

                            <div
                                data-edit-error
                                class="mt-2 hidden rounded-lg bg-red-50 px-3 py-2 text-sm text-red-600"
                            ></div>

                            <div class="mt-3 flex justify-end gap-2">

                                <button
                                    type="button"
                                    data-action="cancel-edit"
                                    class="rounded-xl px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100"
                                >
                                    Annuler
                                </button>

                                <button
                                    type="button"
                                    data-action="save-edit"
                                    class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white"
                                >
                                    <span data-save-text>
                                        Enregistrer
                                    </span>
                                </button>

                            </div>

                        </div>


                        <div
                            data-delete-confirm
                            class="mt-3 hidden rounded-xl border border-red-100 bg-red-50 p-4"
                        >

                            <p class="text-sm font-medium text-gray-900">
                                Supprimer ce commentaire ?
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Cette action est irréversible.
                            </p>

                            <div
                                data-delete-error
                                class="mt-2 hidden text-sm text-red-600"
                            ></div>

                            <div class="mt-3 flex justify-end gap-2">

                                <button
                                    type="button"
                                    data-action="cancel-delete"
                                    class="rounded-xl px-3 py-2 text-sm font-medium text-gray-600 hover:bg-white"
                                >
                                    Annuler
                                </button>

                                <button
                                    type="button"
                                    data-action="confirm-delete"
                                    class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white"
                                >
                                    <span data-delete-text>
                                        Supprimer
                                    </span>
                                </button>

                            </div>

                        </div>


                        <div
                            data-reply-form
                            class="mt-4 hidden"
                        >

                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                                <div class="mb-3 text-xs font-medium text-gray-500">
                                    Répondre à ${escapeHtml(comment.user.name)}
                                </div>

                                <textarea
                                    data-reply-input
                                    rows="3"
                                    maxlength="1000"
                                    placeholder="Écrivez votre réponse..."
                                    class="block w-full resize-none rounded-xl border-gray-300 bg-white text-sm"
                                ></textarea>

                                <div
                                    data-reply-error
                                    class="mt-2 hidden rounded-lg bg-red-50 px-3 py-2 text-sm text-red-600"
                                ></div>

                                <div class="mt-3 flex items-center justify-between">

                                    <span
                                        data-reply-counter
                                        class="text-xs text-gray-400"
                                    >
                                        0 / 1000
                                    </span>

                                    <div class="flex gap-2">

                                        <button
                                            type="button"
                                            data-action="cancel-reply"
                                            class="rounded-xl px-3 py-2 text-sm text-gray-600 hover:bg-gray-100"
                                        >
                                            Annuler
                                        </button>

                                        <button
                                            type="button"
                                            data-action="submit-reply"
                                            class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white disabled:opacity-50"
                                            disabled
                                        >
                                            <span data-reply-submit-text>
                                                Répondre
                                            </span>
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            `;


            commentsList.prepend(
                article
            );

        }


        /*
        |--------------------------------------------------------------------------
        | État vide
        |--------------------------------------------------------------------------
        */

        function showEmptyState() {

            const emptyState =
                document.createElement('div');


            emptyState.dataset.commentsEmpty =
                '';


            emptyState.className =
                'px-6 py-10 text-center';


            emptyState.innerHTML = `

                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100"
                >
                    💬
                </div>

                <p class="mt-3 text-sm font-medium text-gray-900">
                    Aucun commentaire
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Soyez le premier à participer à la discussion.
                </p>

            `;


            commentsList.appendChild(
                emptyState
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Compteur commentaires
        |--------------------------------------------------------------------------
        */

        function updateCommentsCount(count) {

            commentsCount.textContent =
                count;

            commentsLabel.textContent =
                count > 1
                    ? 'commentaires'
                    : 'commentaire';

        }


        /*
        |--------------------------------------------------------------------------
        | Bouton loading
        |--------------------------------------------------------------------------
        */

        function setButtonLoading(
            button,
            textElement,
            loading,
            text
        ) {

            if (!button || !textElement) {
                return;
            }


            button.disabled =
                loading;

            textElement.textContent =
                text;

        }


        /*
        |--------------------------------------------------------------------------
        | Erreur
        |--------------------------------------------------------------------------
        */

        function showError(
            element,
            message
        ) {

            if (!element) {
                return;
            }


            /*
             * Si le premier argument est une Error,
             * on ne peut pas afficher directement l'erreur.
             */

            if (element instanceof Error) {
                return;
            }


            element.textContent =
                message;

            element.classList.remove(
                'hidden'
            );

        }


        function hideError(element) {

            if (!element) {
                return;
            }


            element.textContent =
                '';

            element.classList.add(
                'hidden'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | JSON sécurisé
        |--------------------------------------------------------------------------
        */

        async function parseJson(response) {

            const text =
                await response.text();


            if (!text) {
                return {};
            }


            try {

                return JSON.parse(text);

            } catch {

                return {};

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Protection XSS
        |--------------------------------------------------------------------------
        */

        function escapeHtml(value) {

            const div =
                document.createElement('div');


            div.textContent =
                value ?? '';


            return div.innerHTML;

        }

    @endauth

});
</script>