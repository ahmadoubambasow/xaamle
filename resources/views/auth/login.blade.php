<x-guest-layout>

    {{-- Statut de session --}}
    <x-auth-session-status
        class="mb-5"
        :status="session('status')"
    />


    <form method="POST" action="{{ route('login') }}" class="space-y-5">

        @csrf


        {{-- Email --}}
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

            <div class="flex items-center justify-between">

                <x-input-label
                    for="password"
                    :value="__('Mot de passe')"
                />

                @if (Route::has('password.request'))

                    <a
                        href="{{ route('password.request') }}"
                        class="text-xs font-medium text-gray-500 transition hover:text-gray-900"
                    >
                        Mot de passe oublié ?
                    </a>

                @endif

            </div>


            <x-text-input
                id="password"
                name="password"
                type="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
                class="mt-2 block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-gray-900"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />

        </div>


        {{-- Se souvenir de moi --}}
        <div>

            <label
                for="remember_me"
                class="flex cursor-pointer items-center gap-3"
            >

                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="h-4 w-4 rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-900"
                >

                <span class="text-sm text-gray-600">
                    Se souvenir de moi
                </span>

            </label>

        </div>


        {{-- Connexion --}}
        <button
            type="submit"
            class="flex w-full items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2"
        >
            Se connecter
        </button>

    </form>


    {{-- Inscription --}}
    @if (Route::has('register'))

        <div class="mt-6 border-t border-gray-100 pt-6 text-center">

            <p class="text-sm text-gray-500">
                Vous n'avez pas encore de compte ?
            </p>

            <a
                href="{{ route('register') }}"
                class="mt-2 inline-flex text-sm font-semibold text-gray-900 transition hover:text-gray-500"
            >
                Créer un compte
                <span class="ml-1">
                    →
                </span>
            </a>

        </div>

    @endif

</x-guest-layout>