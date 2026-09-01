<x-guest-layout>

    {{-- Introduction --}}
    <div class="mb-6 text-center">

        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-xl">
            🔒
        </div>

        <h2 class="mt-5 text-xl font-bold tracking-tight text-gray-900">
            Confirmez votre mot de passe
        </h2>

        <p class="mt-3 text-sm leading-6 text-gray-500">
            Cette section de Xaamlé est sécurisée.
        </p>

        <p class="mt-2 text-sm leading-6 text-gray-500">
            Pour continuer, veuillez confirmer votre mot de passe.
        </p>

    </div>


    {{-- Formulaire --}}
    <form
        method="POST"
        action="{{ route('password.confirm') }}"
        class="space-y-5"
    >

        @csrf


        {{-- Mot de passe --}}
        <div>

            <x-input-label
                for="password"
                :value="__('Mot de passe')"
                class="mb-2"
            />

            <x-text-input
                id="password"
                name="password"
                type="password"
                required
                autofocus
                autocomplete="current-password"
                placeholder="••••••••"
                class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-gray-900"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />

        </div>


        {{-- Confirmation --}}
        <button
            type="submit"
            class="flex w-full items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2"
        >
            Confirmer mon mot de passe
        </button>

    </form>


    {{-- Information --}}
    <div class="mt-6 border-t border-gray-100 pt-6 text-center">

        <p class="text-xs leading-5 text-gray-400">
            Votre mot de passe est utilisé uniquement pour
            confirmer votre identité.
        </p>

    </div>

</x-guest-layout>