<x-guest-layout>

    {{-- Introduction --}}
    <div class="mb-6">

        <p class="text-sm leading-6 text-gray-600">
            Vous avez oublié votre mot de passe ?
            Aucun problème.
        </p>

        <p class="mt-2 text-sm leading-6 text-gray-500">
            Saisissez l'adresse e-mail associée à votre compte.
            Nous vous enverrons un lien pour créer un nouveau mot de passe.
        </p>

    </div>


    {{-- Statut de session --}}
    <x-auth-session-status
        class="mb-5"
        :status="session('status')"
    />


    <form
        method="POST"
        action="{{ route('password.email') }}"
        class="space-y-5"
    >

        @csrf


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
                autofocus
                autocomplete="email"
                placeholder="vous@exemple.com"
                class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-gray-900"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />

        </div>


        {{-- Envoyer le lien --}}
        <button
            type="submit"
            class="flex w-full items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2"
        >
            Envoyer le lien de réinitialisation
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