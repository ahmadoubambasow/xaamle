<section>

    {{-- En-tête --}}
    <header>

        <h2 class="text-lg font-semibold text-gray-900">
            Informations du profil
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Modifiez vos informations personnelles, votre photo et votre biographie.
        </p>

    </header>


    {{-- Formulaire de renvoi de vérification --}}
    <form
        id="send-verification"
        method="post"
        action="{{ route('verification.send') }}"
    >
        @csrf
    </form>


    {{-- Formulaire principal --}}
    <form
        method="post"
        action="{{ route('profile.update') }}"
        enctype="multipart/form-data"
        class="mt-6 space-y-7"
        x-data="{
            avatarPreview: '{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}',
            bioLength: {{ strlen(old('bio', $user->bio ?? '')) }}
        }"
    >

        @csrf
        @method('patch')


        {{-- ===================================================== --}}
        {{-- AVATAR --}}
        {{-- ===================================================== --}}

        <div>

            <x-input-label
                for="avatar"
                value="Photo de profil"
            />

            <div class="mt-3 flex items-center gap-5">

                {{-- Aperçu avatar --}}
                <div class="relative h-20 w-20 shrink-0 overflow-hidden rounded-full">

                    {{-- Image --}}
                    <template x-if="avatarPreview">

                        <img
                            :src="avatarPreview"
                            alt="Photo de profil"
                            class="h-full w-full object-cover"
                        >

                    </template>


                    {{-- Avatar par défaut --}}
                    <template x-if="!avatarPreview">

                        <div class="flex h-full w-full items-center justify-center bg-gray-900 text-2xl font-semibold text-white">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                    </template>

                </div>


                {{-- Choix de l'image --}}
                <div>

                    <label
                        for="avatar"
                        class="inline-flex cursor-pointer items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                    >
                        Changer la photo
                    </label>

                    <input
                        id="avatar"
                        name="avatar"
                        type="file"
                        accept="image/jpeg,image/png,image/webp"
                        class="sr-only"
                        @change="
                            const file = $event.target.files[0];

                            if (file) {
                                avatarPreview = URL.createObjectURL(file);
                            }
                        "
                    >

                    <p class="mt-2 text-xs text-gray-500">
                        JPG, PNG ou WebP · 2 Mo maximum
                    </p>

                </div>

            </div>


            <x-input-error
                class="mt-2"
                :messages="$errors->get('avatar')"
            />

        </div>


        {{-- ===================================================== --}}
        {{-- NOM --}}
        {{-- ===================================================== --}}

        <div>

            <x-input-label
                for="name"
                value="Nom"
            />

            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('name')"
            />

        </div>


        {{-- ===================================================== --}}
        {{-- BIO --}}
        {{-- ===================================================== --}}

        <div>

            <div class="flex items-center justify-between">

                <x-input-label
                    for="bio"
                    value="Biographie"
                />

                <span
                    class="text-xs text-gray-400"
                    x-text="bioLength + '/500'"
                ></span>

            </div>


            <textarea
                id="bio"
                name="bio"
                rows="4"
                maxlength="500"
                @input="bioLength = $event.target.value.length"
                class="mt-1 block w-full rounded-lg border-gray-300 text-sm shadow-sm transition focus:border-gray-900 focus:ring-gray-900"
                placeholder="Présentez-vous en quelques mots..."
            >{{ old('bio', $user->bio ?? '') }}</textarea>


            <p class="mt-1.5 text-xs text-gray-500">
                Quelques mots pour permettre à la communauté de mieux vous connaître.
            </p>

            <x-input-error
                class="mt-2"
                :messages="$errors->get('bio')"
            />

        </div>


        {{-- ===================================================== --}}
        {{-- ADRESSE E-MAIL --}}
        {{-- ===================================================== --}}

        <div>

            <x-input-label
                for="email"
                value="Adresse e-mail"
            />

            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />

            <x-input-error
                class="mt-2"
                :messages="$errors->get('email')"
            />


            {{-- Vérification de l'e-mail --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())

                <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4">

                    <div class="flex items-start gap-3">

                        {{-- Icône --}}
                        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-700">

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
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25H4.5a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0l-7.5-4.615A2.25 2.25 0 0 1 2.25 6.993V6.75"
                                />
                            </svg>

                        </div>


                        <div>

                            <p class="text-sm font-medium text-amber-900">
                                Votre adresse e-mail n'est pas encore vérifiée.
                            </p>

                            <p class="mt-1 text-sm text-amber-800">
                                Vérifiez votre boîte de réception pour confirmer votre adresse e-mail.
                            </p>


                            <button
                                form="send-verification"
                                type="submit"
                                class="mt-2 text-sm font-semibold text-amber-900 underline decoration-amber-400 underline-offset-2 transition hover:text-amber-700"
                            >
                                Renvoyer l'e-mail de vérification
                            </button>


                            @if (session('status') === 'verification-link-sent')

                                <p class="mt-3 text-sm font-medium text-green-700">
                                    Un nouveau lien de vérification vient de vous être envoyé.
                                </p>

                            @endif

                        </div>

                    </div>

                </div>

            @endif

        </div>


        {{-- ===================================================== --}}
        {{-- ACTIONS --}}
        {{-- ===================================================== --}}

        <div class="flex flex-wrap items-center gap-4 pt-1">

            <x-primary-button>
                Enregistrer les modifications
            </x-primary-button>


            @if (session('status') === 'profile-updated')

                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-green-600"
                >
                    Modifications enregistrées.
                </p>

            @endif

        </div>

    </form>

</section>
