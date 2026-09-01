@props(['post'])

<section
    id="comments"
    data-comments-section
    data-update-url-template="{{ route('comments.update', ['comment' => '__COMMENT_ID__']) }}"
    data-delete-url-template="{{ route('comments.destroy', ['comment' => '__COMMENT_ID__']) }}"
    data-reply-url-template="{{ route('comments.replies.store', ['comment' => '__COMMENT_ID__']) }}"
    class="mt-6 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm"
>

    {{-- =========================================================
         HEADER
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
            class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-600 transition-transform duration-300"
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
         CONTENU
    ========================================================== --}}

    <div
        id="comments-content"
        class="grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-in-out"
    >
        <div class="min-h-0 overflow-hidden">

            {{-- Formulaire principal --}}
            <x-comments.form :post="$post" />

            {{-- Liste des commentaires --}}
            <div
                id="comments-list"
                class="divide-y divide-gray-100"
            >

                @forelse($post->comments as $comment)

                    <x-comments.item
                        :comment="$comment"
                    />

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

@auth

<script>
document.addEventListener('DOMContentLoaded', () => {

    const section = document.querySelector(
        '[data-comments-section]'
    );

    if (!section) {
        return;
    }


    /* =========================================================
       RÉFÉRENCES
    ========================================================== */

    const commentsList = section.querySelector(
        '#comments-list'
    );

    const commentsCount = section.querySelector(
        '#comments-count'
    );

    const commentsLabel = section.querySelector(
        '#comments-label'
    );

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');

    const updateUrlTemplate =
        section.dataset.updateUrlTemplate;

    const deleteUrlTemplate =
        section.dataset.deleteUrlTemplate;

    const replyUrlTemplate =
        section.dataset.replyUrlTemplate;


    /* =========================================================
       HEADER
    ========================================================== */

    const toggle = section.querySelector(
        '#comments-toggle'
    );

    const content = section.querySelector(
        '#comments-content'
    );

    const icon = section.querySelector(
        '#comments-toggle-icon'
    );


    toggle?.addEventListener('click', () => {

        const isOpen =
            toggle.getAttribute('aria-expanded') === 'true';


        toggle.setAttribute(
            'aria-expanded',
            String(!isOpen)
        );


        if (isOpen) {

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


    /* =========================================================
       CRÉATION COMMENTAIRE
    ========================================================== */

    const commentForm = section.querySelector(
        '#comment-form'
    );


    commentForm?.addEventListener(
        'submit',
        async (event) => {

            event.preventDefault();


            const textarea = commentForm.querySelector(
                '#comment-content'
            );

            const errorBox = commentForm.querySelector(
                '#comment-error'
            );

            const button = commentForm.querySelector(
                '#comment-submit'
            );

            const buttonText = commentForm.querySelector(
                '#comment-submit-text'
            );


            hideError(errorBox);


            const value = textarea.value.trim();


            if (value.length < 2) {

                showError(
                    errorBox,
                    'Votre commentaire doit contenir au moins 2 caractères.'
                );

                textarea.focus();

                return;
            }


            setLoading(
                button,
                buttonText,
                true,
                'Publication...'
            );


            try {

                const response = await fetch(
                    commentForm.action,
                    {
                        method: 'POST',

                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },

                        body: JSON.stringify({
                            content: value
                        })
                    }
                );


                const data = await parseJson(
                    response
                );


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


            } catch (error) {

                console.error(error);

                showError(
                    errorBox,
                    error.message
                );


            } finally {

                setLoading(
                    button,
                    buttonText,
                    false,
                    'Commenter'
                );

            }

        }
    );


    /* =========================================================
       DÉLÉGATION DES ÉVÉNEMENTS
    ========================================================== */

    commentsList.addEventListener(
        'click',
        async (event) => {

            const button = event.target.closest(
                '[data-action]'
            );


            if (!button) {
                return;
            }


            const action =
                button.dataset.action;


            const article =
                button.closest(
                    '[data-comment-id]'
                );


            if (!article) {
                return;
            }


            switch (action) {

                case 'edit':
                    openEdit(article);
                    break;

                case 'cancel-edit':
                    closeEdit(article);
                    break;

                case 'save-edit':
                    await saveEdit(article);
                    break;

                case 'delete':
                    openDelete(article);
                    break;

                case 'cancel-delete':
                    closeDelete(article);
                    break;

                case 'confirm-delete':
                    await deleteComment(article);
                    break;

                case 'reply':
                    openReply(article);
                    break;

                case 'cancel-reply':
                    closeReply(article);
                    break;

                case 'submit-reply':
                    await submitReply(article);
                    break;

                case 'toggle-replies':
                    toggleReplies(article);
                    break;
            }

        }
    );


    /* =========================================================
       COMPTEUR RÉPONSE
    ========================================================== */

    commentsList.addEventListener(
        'input',
        (event) => {

            const input =
                event.target.closest(
                    '[data-reply-input]'
                );


            if (!input) {
                return;
            }


            const article =
                input.closest(
                    '[data-comment-id]'
                );


            if (!article) {
                return;
            }


            const counter =
                article.querySelector(
                    '[data-reply-counter]'
                );

            const button =
                article.querySelector(
                    '[data-action="submit-reply"]'
                );


            if (counter) {

                counter.textContent =
                    `${input.value.length} / 1000`;

            }


            if (button) {

                button.disabled =
                    input.value.trim().length < 2;

            }

        }
    );


    /* =========================================================
       ÉDITION
    ========================================================== */

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

        const text =
            article.querySelector(
                '[data-comment-text]'
            );

        const errorBox =
            article.querySelector(
                '[data-edit-error]'
            );


        if (!display || !edit) {
            return;
        }


        if (input && text) {

            input.value =
                text.textContent.trim();

        }


        hideError(
            errorBox
        );


        edit.classList.add(
            'hidden'
        );

        display.classList.remove(
            'hidden'
        );

    }


    async function saveEdit(article) {

        const url =
            article.dataset.updateUrl;

        const input =
            article.querySelector(
                '[data-edit-input]'
            );

        const errorBox =
            article.querySelector(
                '[data-edit-error]'
            );

        const button =
            article.querySelector(
                '[data-action="save-edit"]'
            );

        const buttonText =
            article.querySelector(
                '[data-save-text]'
            );

        const text =
            article.querySelector(
                '[data-comment-text]'
            );


        if (!url || !input || !errorBox || !text) {
            return;
        }


        hideError(
            errorBox
        );


        const value =
            input.value.trim();


        if (value.length < 2) {

            showError(
                errorBox,
                'Le contenu doit contenir au moins 2 caractères.'
            );

            return;
        }


        setLoading(
            button,
            buttonText,
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
                        content: value
                    })
                }
            );


            const data = await parseJson(
                response
            );


            if (response.status === 422) {

                showError(
                    errorBox,
                    data.errors?.content?.[0]
                    ?? 'Le contenu est invalide.'
                );

                return;
            }


            if (response.status === 403) {

                showError(
                    errorBox,
                    'Vous n’êtes pas autorisé à modifier ce contenu.'
                );

                return;
            }


            if (!response.ok) {

                throw new Error(
                    data.message
                    ?? 'Impossible de modifier le contenu.'
                );
            }


            text.textContent =
                data.comment.content;


            closeEdit(
                article
            );


        } catch (error) {

            console.error(error);

            showError(
                errorBox,
                error.message
            );


        } finally {

            setLoading(
                button,
                buttonText,
                false,
                'Enregistrer'
            );

        }

    }


    /* =========================================================
       SUPPRESSION
    ========================================================== */

    function openDelete(article) {

        const display =
            article.querySelector(
                '[data-comment-display]'
            );

        const confirmation =
            article.querySelector(
                '[data-delete-confirm]'
            );


        if (!confirmation) {
            return;
        }


        display?.classList.add(
            'hidden'
        );

        confirmation.classList.remove(
            'hidden'
        );

    }


    function closeDelete(article) {

        const display =
            article.querySelector(
                '[data-comment-display]'
            );

        const confirmation =
            article.querySelector(
                '[data-delete-confirm]'
            );


        confirmation?.classList.add(
            'hidden'
        );

        display?.classList.remove(
            'hidden'
        );

    }


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

        const errorBox =
            article.querySelector(
                '[data-delete-error]'
            );


        if (!url || !button) {
            return;
        }


        hideError(
            errorBox
        );


        setLoading(
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

                showError(
                    errorBox,
                    'Vous n’êtes pas autorisé à supprimer ce contenu.'
                );

                return;
            }


            if (!response.ok) {

                throw new Error(
                    data.message
                    ?? 'Impossible de supprimer le contenu.'
                );
            }


            const isReply =
                article.classList.contains(
                    'reply-item'
                );


            if (isReply) {

                const repliesContainer =
                    article.closest(
                        '[data-replies-container]'
                    );


                article.remove();


                const parent =
                    repliesContainer?.closest(
                        '[data-comment-id]'
                    );


                if (parent) {

                    updateRepliesCount(
                        parent
                    );

                }


                if (
                    repliesContainer &&
                    repliesContainer.querySelectorAll(
                        '.reply-item'
                    ).length === 0
                ) {

                    repliesContainer.classList.add(
                        'hidden'
                    );

                    const toggleButton =
                        parent?.querySelector(
                            '[data-action="toggle-replies"]'
                        );

                    toggleButton?.remove();

                }

            } else {

                article.remove();


                updateCommentsCount(
                    data.comments_count
                );


                if (
                    data.comments_count === 0 &&
                    !commentsList.querySelector(
                        '[data-comments-empty]'
                    )
                ) {

                    showEmptyState();

                }

            }


        } catch (error) {

            console.error(error);

            showError(
                errorBox,
                error.message
            );


        } finally {

            setLoading(
                button,
                buttonText,
                false,
                'Supprimer'
            );

        }

    }


    /* =========================================================
       RÉPONSES
    ========================================================== */

    function openReply(article) {

        const form =
            article.querySelector(
                '[data-reply-form]'
            );


        if (!form) {
            return;
        }


        form.classList.remove(
            'hidden'
        );


        form.querySelector(
            '[data-reply-input]'
        )?.focus();

    }


    function closeReply(article) {

        const form =
            article.querySelector(
                '[data-reply-form]'
            );


        if (!form) {
            return;
        }


        const input =
            form.querySelector(
                '[data-reply-input]'
            );

        const errorBox =
            form.querySelector(
                '[data-reply-error]'
            );


        if (input) {
            input.value = '';
        }


        hideError(
            errorBox
        );


        form.classList.add(
            'hidden'
        );

    }


    async function submitReply(article) {

        const url =
            article.dataset.replyUrl;

        const input =
            article.querySelector(
                '[data-reply-input]'
            );

        const errorBox =
            article.querySelector(
                '[data-reply-error]'
            );

        const button =
            article.querySelector(
                '[data-action="submit-reply"]'
            );

        const buttonText =
            article.querySelector(
                '[data-reply-submit-text]'
            );


        if (!url || !input) {
            return;
        }


        const value =
            input.value.trim();


        hideError(
            errorBox
        );


        if (value.length < 2) {

            showError(
                errorBox,
                'Votre réponse doit contenir au moins 2 caractères.'
            );

            return;
        }


        setLoading(
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
                        content: value
                    })
                }
            );


            const data =
                await parseJson(response);


            if (response.status === 422) {

                showError(
                    errorBox,
                    data.errors?.content?.[0]
                    ?? 'La réponse est invalide.'
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

            closeReply(
                article
            );


        } catch (error) {

            console.error(error);

            showError(
                errorBox,
                error.message
            );


        } finally {

            setLoading(
                button,
                buttonText,
                false,
                'Répondre'
            );

        }

    }


    /* =========================================================
       AJOUTER UNE RÉPONSE
    ========================================================== */

    function addReply(article, reply) {

        let container =
            article.querySelector(
                '[data-replies-container]'
            );


        if (!container) {

            container =
                document.createElement('div');

            container.dataset.repliesContainer =
                '';

            container.className =
                'mt-4 space-y-4 border-l-2 border-gray-100 pl-4';


            const replyForm =
                article.querySelector(
                    '[data-reply-form]'
                );


            if (replyForm) {

                replyForm.insertAdjacentElement(
                    'afterend',
                    container
                );

            } else {

                article.appendChild(
                    container
                );

            }


            createRepliesToggle(
                article
            );

        }


        const replyArticle =
            document.createElement('article');


        replyArticle.dataset.commentId =
            reply.id;

        replyArticle.dataset.replyId =
            reply.id;

        replyArticle.dataset.updateUrl =
            updateUrlTemplate.replace(
                '__COMMENT_ID__',
                reply.id
            );

        replyArticle.dataset.deleteUrl =
            deleteUrlTemplate.replace(
                '__COMMENT_ID__',
                reply.id
            );

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

                    <div data-comment-display>

                        <div class="flex items-start justify-between gap-3">

                            <div>

                                <div class="flex flex-wrap items-center gap-x-2 gap-y-1">

                                    <span class="text-sm font-semibold text-gray-900">
                                        ${escapeHtml(reply.user.name)}
                                    </span>

                                    <span class="text-xs text-gray-400">
                                        ${escapeHtml(reply.created_at)}
                                    </span>

                                </div>

                            </div>


                            <div class="flex shrink-0 items-center gap-1">

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

                        </div>


                        <p
                            data-comment-text
                            class="mt-1 whitespace-pre-line text-sm leading-6 text-gray-600"
                        >
                            ${escapeHtml(reply.content)}
                        </p>

                    </div>


                    {{-- Formulaire édition dynamique --}}
                    <div
                        data-comment-edit
                        class="hidden"
                    >

                        <textarea
                            data-edit-input
                            rows="3"
                            maxlength="1000"
                            class="w-full resize-none rounded-xl border border-gray-300 px-3 py-2 text-sm text-gray-700 outline-none transition focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                        >${escapeHtml(reply.content)}</textarea>


                        <div
                            data-edit-error
                            class="mt-2 hidden text-sm text-red-600"
                        ></div>


                        <div class="mt-2 flex items-center justify-end gap-2">

                            <button
                                type="button"
                                data-action="cancel-edit"
                                class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100"
                            >
                                Annuler
                            </button>

                            <button
                                type="button"
                                data-action="save-edit"
                                class="rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <span data-save-text>
                                    Enregistrer
                                </span>
                            </button>

                        </div>

                    </div>


                    {{-- Confirmation suppression dynamique --}}
                    <div
                        data-delete-confirm
                        class="mt-3 hidden rounded-xl border border-red-100 bg-red-50 p-3"
                    >

                        <p class="text-sm text-red-700">
                            Supprimer cette réponse ?
                        </p>


                        <div
                            data-delete-error
                            class="mt-2 hidden text-sm text-red-600"
                        ></div>


                        <div class="mt-3 flex justify-end gap-2">

                            <button
                                type="button"
                                data-action="cancel-delete"
                                class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-white"
                            >
                                Annuler
                            </button>

                            <button
                                type="button"
                                data-action="confirm-delete"
                                class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
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


    /* =========================================================
       TOGGLE RÉPONSES
    ========================================================== */

    function createRepliesToggle(article) {

        const actions =
            article.querySelector(
                '[data-action="reply"]'
            )?.parentElement;


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


    function toggleReplies(article) {

        const container =
            article.querySelector(
                '[data-replies-container]'
            );


        if (!container) {
            return;
        }


        container.classList.toggle(
            'hidden'
        );

    }


    function updateRepliesCount(article) {

        const count =
            article.querySelectorAll(
                ':scope > div [data-replies-container] .reply-item'
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


    /* =========================================================
       AJOUTER COMMENTAIRE
    ========================================================== */

    function addComment(comment) {

        commentsList
            .querySelector(
                '[data-comments-empty]'
            )
            ?.remove();


        const article =
            document.createElement('article');


        article.dataset.commentId =
            comment.id;

        article.dataset.updateUrl =
            updateUrlTemplate.replace(
                '__COMMENT_ID__',
                comment.id
            );

        article.dataset.deleteUrl =
            deleteUrlTemplate.replace(
                '__COMMENT_ID__',
                comment.id
            );

        article.dataset.replyUrl =
            replyUrlTemplate.replace(
                '__COMMENT_ID__',
                comment.id
            );

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


                            <div class="flex items-center gap-1">

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


                        <div class="mt-3">

                            <button
                                type="button"
                                data-action="reply"
                                class="text-sm font-medium text-gray-500 transition hover:text-gray-900"
                            >
                                ↩ Répondre
                            </button>

                        </div>

                    </div>


                    {{-- Édition dynamique --}}
                    <div
                        data-comment-edit
                        class="hidden"
                    >

                        <textarea
                            data-edit-input
                            rows="3"
                            maxlength="1000"
                            class="w-full resize-none rounded-xl border border-gray-300 px-3 py-2 text-sm text-gray-700 outline-none transition focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                        >${escapeHtml(comment.content)}</textarea>


                        <div
                            data-edit-error
                            class="mt-2 hidden text-sm text-red-600"
                        ></div>


                        <div class="mt-2 flex items-center justify-end gap-2">

                            <button
                                type="button"
                                data-action="cancel-edit"
                                class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100"
                            >
                                Annuler
                            </button>

                            <button
                                type="button"
                                data-action="save-edit"
                                class="rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <span data-save-text>
                                    Enregistrer
                                </span>
                            </button>

                        </div>

                    </div>


                    {{-- Confirmation suppression dynamique --}}
                    <div
                        data-delete-confirm
                        class="mt-3 hidden rounded-xl border border-red-100 bg-red-50 p-3"
                    >

                        <p class="text-sm text-red-700">
                            Supprimer ce commentaire ?
                        </p>


                        <div
                            data-delete-error
                            class="mt-2 hidden text-sm text-red-600"
                        ></div>


                        <div class="mt-3 flex justify-end gap-2">

                            <button
                                type="button"
                                data-action="cancel-delete"
                                class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-white"
                            >
                                Annuler
                            </button>

                            <button
                                type="button"
                                data-action="confirm-delete"
                                class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <span data-delete-text>
                                    Supprimer
                                </span>
                            </button>

                        </div>

                    </div>


                    {{-- Réponse dynamique --}}
                    <div
                        data-reply-form
                        class="mt-4 hidden"
                    >

                        <textarea
                            data-reply-input
                            rows="2"
                            maxlength="1000"
                            placeholder="Écrire une réponse..."
                            class="w-full resize-none rounded-xl border border-gray-300 px-3 py-2 text-sm text-gray-700 outline-none transition focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                        ></textarea>


                        <div class="mt-1 flex items-center justify-between">

                            <div
                                data-reply-error
                                class="hidden text-sm text-red-600"
                            ></div>

                            <span
                                data-reply-counter
                                class="ml-auto text-xs text-gray-400"
                            >
                                0 / 1000
                            </span>

                        </div>


                        <div class="mt-2 flex justify-end gap-2">

                            <button
                                type="button"
                                data-action="cancel-reply"
                                class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100"
                            >
                                Annuler
                            </button>

                            <button
                                type="button"
                                data-action="submit-reply"
                                disabled
                                class="rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <span data-reply-submit-text>
                                    Répondre
                                </span>
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        `;


        commentsList.prepend(
            article
        );

    }


    /* =========================================================
       COMPTEUR PRINCIPAL
    ========================================================== */

    function updateCommentsCount(count) {

        commentsCount.textContent =
            count;

        commentsLabel.textContent =
            count > 1
                ? 'commentaires'
                : 'commentaire';

    }


    /* =========================================================
       ÉTAT VIDE
    ========================================================== */

    function showEmptyState() {

        const empty =
            document.createElement('div');


        empty.dataset.commentsEmpty =
            '';


        empty.className =
            'px-6 py-10 text-center';


        empty.innerHTML = `

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
            empty
        );

    }


    /* =========================================================
       HELPERS
    ========================================================== */

    function setLoading(
        button,
        text,
        loading,
        label
    ) {

        if (!button) {
            return;
        }


        button.disabled =
            loading;


        if (text) {

            text.textContent =
                label;

        }

    }


    function showError(
        element,
        message
    ) {

        if (!element) {
            return;
        }


        element.textContent =
            message ?? 'Une erreur est survenue.';


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


    function escapeHtml(value) {

        const element =
            document.createElement('div');


        element.textContent =
            value ?? '';


        return element.innerHTML;

    }

});
</script>

@endauth