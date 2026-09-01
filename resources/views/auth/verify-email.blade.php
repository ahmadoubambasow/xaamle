<x-guest-layout>

    {{-- Introduction --}}
    <div class="mb-6 text-center">

        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-2xl">
            ✉
        </div>

        <h2 class="mt-5 text-xl font-bold tracking-tight text-gray-900">
            Vérifiez votre adresse e-mail
        </h2>

        <p class="mt-3 text-sm leading-6 text-gray-500">
            Merci de vous être inscrit sur Xaamlé !
        </p>

        <p class="mt-2 text-sm leading-6 text-gray-500">
            Nous vous avons envoyé un e-mail contenant un lien de
            vérification. Cliquez sur ce lien pour activer votre compte.
        </p>

    </div>


    {{-- Message après renvoi --}}
    @if (session('status') == 'verification-link-sent')

        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3">

            <p class="text-sm font-medium leading-5 text-green-700">
                Un nouveau lien de vérification vient d'être envoyé
                à l'adresse e-mail associée à votre compte.
            </p>

        </div>

    @endif


    {{-- Actions --}}
    <div class="space-y-3">

        {{-- Renvoyer l'e-mail --}}
        <form
            method="POST"
            action="{{ route('verification.send') }}"
        >

            @csrf

            <button
                type="submit"
                class="flex w-full items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2"
            >
                Renvoyer l'e-mail de vérification
            </button>

        </form>


        {{-- Déconnexion --}}
        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="flex w-full items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2"
            >
                Se déconnecter
            </button>

        </form>

    </div>


    {{-- Information supplémentaire --}}
    <div class="mt-6 border-t border-gray-100 pt-6 text-center">

        <p class="text-xs leading-5 text-gray-400">
            Vous ne trouvez pas l'e-mail ?
            Pensez à vérifier votre dossier
            <span class="font-medium text-gray-500">
                spam
            </span>
            ou
            <span class="font-medium text-gray-500">
                courrier indésirable
            </span>.
        </p>

    </div>

</x-guest-layout>