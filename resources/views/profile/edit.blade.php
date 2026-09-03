<x-app-layout>

    {{-- ========================================================= --}}
    {{-- EN-TÊTE --}}
    {{-- ========================================================= --}}

    <x-slot name="header">

        <div>

            <h2 class="text-xl font-semibold tracking-tight text-gray-900">
                Mon profil
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Gérez vos informations personnelles et la sécurité de votre compte.
            </p>

        </div>

    </x-slot>


    {{-- ========================================================= --}}
    {{-- CONTENU --}}
    {{-- ========================================================= --}}

    <div class="min-h-screen bg-gray-50 py-10 sm:py-12">

        <div class="mx-auto max-w-4xl space-y-6 px-4 sm:px-6 lg:px-8">


            {{-- ================================================= --}}
            {{-- INFORMATIONS DU PROFIL --}}
            {{-- ================================================= --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="p-5 sm:p-8">

                    <div class="max-w-2xl">

                        @include('profile.partials.update-profile-information-form')

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- MOT DE PASSE --}}
            {{-- ================================================= --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="p-5 sm:p-8">

                    <div class="max-w-2xl">

                        @include('profile.partials.update-password-form')

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- SUPPRESSION DU COMPTE --}}
            {{-- ================================================= --}}

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="p-5 sm:p-8">

                    <div class="max-w-2xl">

                        @include('profile.partials.delete-user-form')

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- RETOUR --}}
            {{-- ================================================= --}}

            <div class="pb-4 text-center">

                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-gray-900"
                >

                    <svg
                        class="h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
                        />
                    </svg>

                    Retour à l'accueil

                </a>

            </div>

        </div>

    </div>

</x-app-layout>
