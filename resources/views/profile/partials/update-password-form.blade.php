<section>

    {{-- En-tête --}}
    <header>

        <h2 class="text-lg font-semibold text-gray-900">
            Modifier le mot de passe
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Utilisez un mot de passe long et aléatoire pour renforcer la sécurité de votre compte.
        </p>

    </header>


    {{-- Formulaire --}}
    <form
        method="post"
        action="{{ route('password.update') }}"
        class="mt-6 space-y-6"
    >

        @csrf
        @method('put')


        {{-- Mot de passe actuel --}}
        <div>

            <x-input-label
                for="update_password_current_password"
                value="Mot de passe actuel"
            />

            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="current-password"
            />

            <x-input-error
                :messages="$errors->updatePassword->get('current_password')"
                class="mt-2"
            />

        </div>


        {{-- Nouveau mot de passe --}}
        <div>

            <x-input-label
                for="update_password_password"
                value="Nouveau mot de passe"
            />

            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->updatePassword->get('password')"
                class="mt-2"
            />

        </div>


        {{-- Confirmation --}}
        <div>

            <x-input-label
                for="update_password_password_confirmation"
                value="Confirmer le nouveau mot de passe"
            />

            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-2"
            />

        </div>


        {{-- Actions --}}
        <div class="flex items-center gap-4 pt-2">

            <x-primary-button>
                Modifier le mot de passe
            </x-primary-button>


            @if (session('status') === 'password-updated')

                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-green-600"
                >
                    Mot de passe modifié.
                </p>

            @endif

        </div>

    </form>

</section>
