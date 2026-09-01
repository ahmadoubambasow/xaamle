@props([
    'content' => ''
])

<div
    data-comment-edit
    class="hidden"
>

    <textarea
        data-edit-input
        maxlength="1000"
        rows="3"
        class="block w-full resize-none rounded-xl border-gray-300 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900"
    >{{ $content }}</textarea>


    <div
        data-edit-error
        class="mt-2 hidden rounded-lg bg-red-50 px-3 py-2 text-sm text-red-600"
    ></div>


    <div class="mt-3 flex justify-end gap-2">

        <button
            type="button"
            data-action="cancel-edit"
            class="rounded-xl px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100"
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