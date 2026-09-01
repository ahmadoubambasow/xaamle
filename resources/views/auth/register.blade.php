<x-guest-layout>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">

        @csrf


        {{-- Nom --}}
        <div>

            <x-input-label
                for="name"
                :value="__('Nom')"
                class="mb-2"
            />

            <x-text-input
                id="name"
                name="name"
                type="text"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
                placeholder="Votre nom"
                class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-gray-900"
            />

            <x-input-error
                :messages="$errors->get('name')"
                class="mt-2"
            />

        </div>


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
                :value="old('email')"
                required
                autocomplete="username"
                placeholder="vous@exemple.com"
                class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-gray-900"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />

        </div>


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
                autocomplete="new-password"
                placeholder="••••••••"
                class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-gray-900"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />

        </div>


        {{-- Confirmation du mot de passe --}}
        <div>

            <x-input-label
                for="password_confirmation"
                :value="__('Confirmer le mot de passe')"
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


        {{-- Inscription --}}
        <button
            type="submit"
            class="flex w-full items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2"
        >
            Créer mon compte
        </button>

    </form>


    {{-- Connexion --}}
    <div class="mt-6 border-t border-gray-100 pt-6 text-center">

        <p class="text-sm text-gray-500">
            Vous avez déjà un compte ?
        </p>

        <a
            href="{{ route('login') }}"
            class="mt-2 inline-flex text-sm font-semibold text-gray-900 transition hover:text-gray-500"
        >
            Se connecter
            <span class="ml-1">
                →
            </span>
        </a>

    </div>

</x-guest-layout>