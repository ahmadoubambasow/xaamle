<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Modifier la publication
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Modifiez votre contenu avant de le partager avec la communauté.
                </p>
            </div>

            <a
                href="{{ route('posts.show', $post) }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
            >
                ← Retour à la publication
            </a>

        </div>
    </x-slot>


    <main class="min-h-screen bg-gray-50 py-10">

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Erreurs de validation --}}
            @if ($errors->any())

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                    <div class="flex gap-3">

                        <div class="text-red-500">
                            ⚠️
                        </div>

                        <div>

                            <h3 class="text-sm font-semibold text-red-800">
                                Vérifiez les informations saisies
                            </h3>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            <form
                action="{{ route('posts.update', $post) }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6"
            >

                @csrf

                @method('PUT')


                {{-- Informations --}}
                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="border-b border-gray-100 px-6 py-5">

                        <h3 class="text-lg font-semibold text-gray-900">
                            Contenu de la publication
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Mettez à jour les informations de votre publication.
                        </p>

                    </div>


                    <div class="space-y-6 p-6">

                        @include('posts.partials.form')

                    </div>

                </div>


                {{-- Actions --}}
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <a
                        href="{{ route('posts.show', $post) }}"
                        class="inline-flex justify-center rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                    >
                        Annuler
                    </a>


                    <button
                        type="submit"
                        class="inline-flex justify-center rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2"
                    >
                        Enregistrer les modifications
                    </button>

                </div>

            </form>

        </div>

    </main>

</x-app-layout>