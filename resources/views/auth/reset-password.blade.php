<x-guest-layout>

    {{-- Introduction --}}
    <div class="mb-6">

        <p class="text-sm leading-6 text-gray-600">
            Créez un nouveau mot de passe pour votre compte Xaamlé.
        </p>

        <p class="mt-2 text-sm leading-6 text-gray-500">
            Choisissez un mot de passe suffisamment sécurisé
            et facile à retenir.
        </p>

    </div>


    <form
        method="POST"
        action="{{ route('password.store') }}"
        class="space-y-5"
    >

        @csrf


        {{-- Token de réinitialisation --}}
        <input
            type="hidden"
            name="token"
            value="{{ $request->route('token') }}"
        >


        {{-- Adresse e-mail --}}
        <div>

            <x-input-label
                for="email"
                :value="__('Adresse e-mail')"
                class="mb-2"
            />

            <x-text-input
                id="email"
                name="email"
                type="email"
                :value="old('email', $request->email)"
                required
                autofocus
                autocomplete="username"
                placeholder="vous@exemple.com"
                class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-gray-900"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />

        </div>


        {{-- Nouveau mot de passe --}}
        <div>

            <x-input-label
                for="password"
                :value="__('Nouveau mot de passe')"
                class="mb-2"
            />

            <x-text-input
                id="password"
                name="password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-gray-900"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />

        </div>


        {{-- Confirmation --}}
        <div>

            <x-input-label
                for="password_confirmation"
                :value="__('Confirmer le nouveau mot de passe')"
                class="mb-2"
            />

            <x-text-input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-gray-900"
            />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />

        </div>


        {{-- Réinitialisation --}}
        <button
            type="submit"
            class="flex w-full items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2"
        >
            Réinitialiser le mot de passe
        </button>

    </form>


    {{-- Retour connexion --}}
    <div class="mt-6 border-t border-gray-100 pt-6 text-center">

        <a
            href="{{ route('login') }}"
            class="inline-flex items-center text-sm font-semibold text-gray-900 transition hover:text-gray-500"
        >
            ← Retour à la connexion
        </a>

    </div>

</x-guest-layout>