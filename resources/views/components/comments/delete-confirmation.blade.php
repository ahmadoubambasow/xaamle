@props([
    'message' => 'Supprimer ce contenu ?'
])

<div
    data-delete-confirm
    class="mt-3 hidden rounded-xl border border-red-100 bg-red-50 p-4"
>

    <p class="text-sm font-medium text-gray-900">
        {{ $message }}
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