<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                Nouvelle publication
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Partagez une idée, une connaissance ou une expérience avec la communauté.
            </p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-10">

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- Erreurs --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                    <h3 class="text-sm font-semibold text-red-800">
                        Vérifiez les informations saisies
                    </h3>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif


            <form
                action="{{ route('posts.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6"
            >

                @csrf

                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="border-b border-gray-100 px-6 py-5">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Votre publication
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Donnez un titre clair et présentez votre contenu.
                        </p>
                    </div>

                    <div class="space-y-6 p-6">

                        @include('posts.partials.form')

                    </div>

                </div>


                {{-- Actions --}}
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('posts.index') }}"
                        class="inline-flex justify-center rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                    >
                        Annuler
                    </a>

                    <button
                        type="submit"
                        class="inline-flex justify-center rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-800"
                    >
                        Créer la publication
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>