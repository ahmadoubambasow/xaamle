@props([
    'title' => 'Supprimer cette publication ?',
    'message' => 'Cette action est définitive. La publication sera supprimée de façon permanente.',
    'buttonText' => 'Supprimer',
])

<div
    x-data="{ open: false }"
    {{ $attributes }}
>
    {{-- Bouton supprimer --}}
    <button
        type="button"
        @click="open = true"
        class="inline-flex items-center rounded-lg px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50"
    >
        {{ $buttonText }}
    </button>

    {{-- Overlay --}}
    <div
        x-show="open"
        x-cloak
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4"
        @keydown.escape.window="open = false"
    >

        {{-- Modale --}}
        <div
            x-show="open"
            x-transition
            @click.outside="open = false"
            class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl"
        >

            {{-- Contenu --}}
            <div class="p-6">

                {{-- Icône --}}
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                    <svg
                        class="h-6 w-6 text-red-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4a2 2 0 00-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                        />
                    </svg>
                </div>

                {{-- Texte --}}
                <div class="mt-5">

                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ $title }}
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        {{ $message }}
                    </p>

                </div>

            </div>


            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end">

                <button
                    type="button"
                    @click="open = false"
                    class="inline-flex justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Annuler
                </button>

                {{ $slot }}

            </div>

        </div>

    </div>
</div>