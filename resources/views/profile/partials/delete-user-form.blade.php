<section class="space-y-6">

    {{-- En-tête --}}
    <header>

        <h2 class="text-lg font-semibold text-gray-900">
            Supprimer le compte
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            La suppression de votre compte est définitive. Toutes vos publications,
            données et informations associées seront supprimées de manière permanente.
            Pensez à sauvegarder les informations que vous souhaitez conserver avant de continuer.
        </p>

    </header>


    {{-- Zone de suppression --}}
    <div class="rounded-xl border border-red-200 bg-red-50 p-5">

        <div class="flex items-start gap-3">

            {{-- Icône --}}
            <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">

                <svg
                    class="h-5 w-5"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0C7.91 2.748 7 3.732 7 4.912v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                    />
                </svg>

            </div>


            <div class="flex-1">

                <h3 class="text-sm font-semibold text-red-900">
                    Suppression définitive
                </h3>

                <p class="mt-1 text-sm leading-6 text-red-800">
                    Cette action supprimera définitivement votre compte et les données
                    qui lui sont associées. Elle ne peut pas être annulée.
                </p>


                {{-- Bouton --}}
                <div class="mt-4">

                    <x-danger-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    >
                        Supprimer mon compte
                    </x-danger-button>

                </div>

            </div>

        </div>

    </div>


    {{-- Modal de confirmation --}}
    <x-modal
        name="confirm-user-deletion"
        :show="$errors->userDeletion->isNotEmpty()"
        focusable
    >

        <form
            method="post"
            action="{{ route('profile.destroy') }}"
            class="p-6"
        >

            @csrf
            @method('delete')


            {{-- Titre --}}
            <h2 class="text-lg font-semibold text-gray-900">
                Confirmer la suppression du compte
            </h2>


            {{-- Explication --}}
            <p class="mt-1 text-sm leading-6 text-gray-600">
                Êtes-vous certain de vouloir supprimer votre compte ?
                Cette action est définitive et supprimera toutes vos données.
                Pour confirmer la suppression, saisissez votre mot de passe.
            </p>


            {{-- Mot de passe --}}
            <div class="mt-6">

                <x-input-label
                    for="password"
                    value="Mot de passe"
                    class="sr-only"
                />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="Saisissez votre mot de passe"
                />

                <x-input-error
                    :messages="$errors->userDeletion->get('password')"
                    class="mt-2"
                />

            </div>


            {{-- Actions --}}
            <div class="mt-6 flex justify-end gap-3">

                <x-secondary-button
                    type="button"
                    x-on:click="$dispatch('close')"
                >
                    Annuler
                </x-secondary-button>


                <x-danger-button>
                    Supprimer définitivement
                </x-danger-button>

            </div>

        </form>

    </x-modal>

</section>
