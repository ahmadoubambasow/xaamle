@props([
    'userName'
])

<div
    data-reply-form
    class="mt-4 hidden"
>

    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

        <div class="mb-3 flex items-center gap-2">

            {{-- Avatar --}}
            <div class="h-7 w-7 shrink-0 overflow-hidden rounded-full">

                @if (auth()->user()->avatar)

                    <img
                        src="{{ asset('storage/' . auth()->user()->avatar) }}"
                        alt="Photo de {{ auth()->user()->name }}"
                        class="h-full w-full object-cover"
                    >

                @else

                    <div class="flex h-full w-full items-center justify-center bg-gray-900 text-[10px] font-semibold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                @endif

            </div>

            <span class="text-xs font-medium text-gray-500">
                Répondre à {{ $userName }}
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
                    disabled
                    class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <span data-reply-submit-text>
                        Répondre
                    </span>
                </button>

            </div>

        </div>

    </div>

</div>