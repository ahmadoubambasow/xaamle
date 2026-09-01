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


    {{-- Icône ouverture --}}
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
             FORMULAIRE
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

                        {{-- Avatar utilisateur --}}
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


                            {{-- Erreur création --}}
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
             LISTE
        ================================================== --}}

        <div
            id="comments-list"
            class="divide-y divide-gray-100"
        >

            @forelse ($post->comments as $comment)

                <article
                    data-comment-id="{{ $comment->id }}"
                    class="px-6 py-5"
                >

                    <div class="flex gap-3">

                        {{-- Avatar --}}
                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-900 text-xs font-semibold text-white"
                        >
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>


                        <div class="min-w-0 flex-1">

                            {{-- =================================
                                 AFFICHAGE NORMAL
                            ================================== --}}

                            <div data-comment-display>

                                <div class="flex flex-wrap items-center gap-x-2 gap-y-1">

                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $comment->user->name }}
                                    </p>

                                    <span class="text-xs text-gray-400">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </span>

                                </div>


                                <p
                                    data-comment-text
                                    class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-700"
                                >
                                    {{ $comment->content }}
                                </p>


                                {{-- Actions propriétaire --}}
                                @auth

                                    @if (auth()->id() === $comment->user_id)

                                        <div class="mt-3 flex items-center gap-3">

                                            <button
                                                type="button"
                                                data-action="edit"
                                                class="text-xs font-medium text-gray-500 transition hover:text-gray-900"
                                            >
                                                Modifier
                                            </button>

                                            <button
                                                type="button"
                                                data-action="delete"
                                                class="text-xs font-medium text-red-500 transition hover:text-red-700"
                                            >
                                                Supprimer
                                            </button>

                                        </div>

                                    @endif

                                @endauth

                            </div>


                            {{-- =================================
                                 FORMULAIRE MODIFICATION
                            ================================== --}}

                            @auth

                                @if (auth()->id() === $comment->user_id)

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


                                        <div class="mt-3 flex items-center justify-between">

                                            <span class="text-xs text-gray-400">
                                                1000 caractères maximum
                                            </span>

                                            <div class="flex items-center gap-2">

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

                                    </div>

                                @endif

                            @endauth


                            {{-- =================================
                                 CONFIRMATION SUPPRESSION
                            ================================== --}}

                            @auth

                                @if (auth()->id() === $comment->user_id)

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
    | Ouverture / fermeture
    |--------------------------------------------------------------------------
    */

    const toggle = commentsSection.querySelector('#comments-toggle');
    const content = commentsSection.querySelector('#comments-content');
    const icon = commentsSection.querySelector('#comments-toggle-icon');


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


    /*
    |--------------------------------------------------------------------------
    | AJAX utilisateur connecté
    |--------------------------------------------------------------------------
    */

    @auth

        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content');


        if (!csrfToken) {

            console.error(
                'Token CSRF introuvable.'
            );

            return;
        }


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
        | Création commentaire
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

                        const message =
                            data.errors?.content?.[0]
                            ?? 'Le commentaire est invalide.';

                        showError(
                            errorBox,
                            message
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
        | Actions sur les commentaires
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


                /*
                | Modifier
                */

                if (action === 'edit') {

                    openEdit(article);

                    return;
                }


                /*
                | Annuler modification
                */

                if (action === 'cancel-edit') {

                    closeEdit(article);

                    return;
                }


                /*
                | Enregistrer modification
                */

                if (action === 'save-edit') {

                    await saveEdit(article);

                    return;
                }


                /*
                | Demander suppression
                */

                if (action === 'delete') {

                    openDeleteConfirmation(article);

                    return;
                }


                /*
                | Annuler suppression
                */

                if (action === 'cancel-delete') {

                    closeDeleteConfirmation(article);

                    return;
                }


                /*
                | Confirmer suppression
                */

                if (action === 'confirm-delete') {

                    await deleteComment(article);

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Ouvrir édition
        |--------------------------------------------------------------------------
        */

        function openEdit(article) {

            const display =
                article.querySelector('[data-comment-display]');

            const edit =
                article.querySelector('[data-comment-edit]');

            const input =
                article.querySelector('[data-edit-input]');


            if (!display || !edit || !input) {
                return;
            }


            display.classList.add('hidden');

            edit.classList.remove('hidden');

            input.focus();

            input.setSelectionRange(
                input.value.length,
                input.value.length
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Fermer édition
        |--------------------------------------------------------------------------
        */

        function closeEdit(article) {

            const display =
                article.querySelector('[data-comment-display]');

            const edit =
                article.querySelector('[data-comment-edit]');

            const input =
                article.querySelector('[data-edit-input]');

            const error =
                article.querySelector('[data-edit-error]');


            if (!display || !edit || !input) {
                return;
            }


            const original =
                article.querySelector('[data-comment-text]')
                    ?.textContent
                    ?.trim();


            if (original !== undefined) {
                input.value = original;
            }


            hideError(error);

            edit.classList.add('hidden');

            display.classList.remove('hidden');

        }


        /*
        |--------------------------------------------------------------------------
        | Enregistrer modification
        |--------------------------------------------------------------------------
        */

        async function saveEdit(article) {

            const commentId =
                article.dataset.commentId;

            const input =
                article.querySelector('[data-edit-input]');

            const error =
                article.querySelector('[data-edit-error]');

            const saveButton =
                article.querySelector('[data-action="save-edit"]');

            const saveText =
                article.querySelector('[data-save-text]');

            const text =
                article.querySelector('[data-comment-text]');


            if (
                !commentId ||
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
                    `/comments/${commentId}`,
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

                    const message =
                        data.errors?.content?.[0]
                        ?? 'Le commentaire est invalide.';

                    showError(
                        error,
                        message
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
                    errorBox,
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
        | Ouvrir confirmation suppression
        |--------------------------------------------------------------------------
        */

        function openDeleteConfirmation(article) {

            const display =
                article.querySelector('[data-comment-display]');

            const confirmation =
                article.querySelector('[data-delete-confirm]');


            if (!display || !confirmation) {
                return;
            }


            display.classList.add('hidden');

            confirmation.classList.remove('hidden');

        }


        /*
        |--------------------------------------------------------------------------
        | Fermer confirmation suppression
        |--------------------------------------------------------------------------
        */

        function closeDeleteConfirmation(article) {

            const display =
                article.querySelector('[data-comment-display]');

            const confirmation =
                article.querySelector('[data-delete-confirm]');


            if (!display || !confirmation) {
                return;
            }


            confirmation.classList.add('hidden');

            display.classList.remove('hidden');

        }


        /*
        |--------------------------------------------------------------------------
        | Supprimer commentaire
        |--------------------------------------------------------------------------
        */

        async function deleteComment(article) {

            const commentId =
                article.dataset.commentId;

            const button =
                article.querySelector('[data-action="confirm-delete"]');

            const buttonText =
                article.querySelector('[data-delete-text]');


            if (
                !commentId ||
                !button ||
                !buttonText
            ) {
                return;
            }


            setButtonLoading(
                button,
                buttonText,
                true,
                'Suppression...'
            );


            try {

                const response = await fetch(
                    `/comments/${commentId}`,
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


                /*
                | Afficher l'état vide si nécessaire
                */

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


                const confirmation =
                    article.querySelector(
                        '[data-delete-confirm]'
                    );


                if (confirmation) {

                    let errorBox =
                        confirmation.querySelector(
                            '[data-delete-error]'
                        );


                    if (!errorBox) {

                        errorBox =
                            document.createElement('div');

                        errorBox.dataset.deleteError = '';

                        errorBox.className =
                            'mt-2 text-sm text-red-600';

                        confirmation.insertBefore(
                            errorBox,
                            confirmation.firstElementChild?.nextSibling
                        );

                    }


                    errorBox.textContent =
                        error.message
                        ?? 'Impossible de supprimer le commentaire.';

                }


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
        | Ajouter commentaire dans la liste
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

            article.className =
                'px-6 py-5';


            const initial =
                comment.user.name
                    .charAt(0)
                    .toUpperCase();


            article.innerHTML = `

                <div class="flex gap-3">

                    <div
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-900 text-xs font-semibold text-white"
                    >
                        ${escapeHtml(initial)}
                    </div>


                    <div class="min-w-0 flex-1">

                        <div data-comment-display>

                            <div class="flex flex-wrap items-center gap-x-2 gap-y-1">

                                <p class="text-sm font-semibold text-gray-900">
                                    ${escapeHtml(comment.user.name)}
                                </p>

                                <span class="text-xs text-gray-400">
                                    ${escapeHtml(comment.created_at)}
                                </span>

                            </div>


                            <p
                                data-comment-text
                                class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-700"
                            >
                                ${escapeHtml(comment.content)}
                            </p>


                            <div class="mt-3 flex items-center gap-3">

                                <button
                                    type="button"
                                    data-action="edit"
                                    class="text-xs font-medium text-gray-500 transition hover:text-gray-900"
                                >
                                    Modifier
                                </button>

                                <button
                                    type="button"
                                    data-action="delete"
                                    class="text-xs font-medium text-red-500 transition hover:text-red-700"
                                >
                                    Supprimer
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


                        <div class="mt-3 flex items-center justify-between">

                            <span class="text-xs text-gray-400">
                                1000 caractères maximum
                            </span>

                            <div class="flex items-center gap-2">

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
                                    class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800"
                                >
                                    <span data-save-text>
                                        Enregistrer
                                    </span>
                                </button>

                            </div>

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
                                class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700"
                            >
                                <span data-delete-text>
                                    Supprimer
                                </span>
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        `;


        commentsList.prepend(article);

    }


    /*
    |--------------------------------------------------------------------------
    | État vide
    |--------------------------------------------------------------------------
    */

    function showEmptyState() {

        const emptyState =
            document.createElement('div');

        emptyState.dataset.commentsEmpty = '';

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
    | Compteur
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
    | Loading bouton
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


        element.textContent = '';

        element.classList.add(
            'hidden'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Lecture JSON sécurisée
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


}); </script>
