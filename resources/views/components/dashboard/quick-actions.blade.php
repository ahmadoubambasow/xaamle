<section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

    <h2 class="text-base font-semibold text-gray-900">
        Actions rapides
    </h2>

    <p class="mt-1 text-sm text-gray-500">
        Accédez rapidement aux principales fonctionnalités.
    </p>

    <div class="mt-5 space-y-2">

        <a
            href="{{ route('posts.create') }}"
            class="flex items-center gap-3 rounded-xl p-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
        >
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100">
                ✍️
            </span>

            Écrire une publication
        </a>

        <a
            href="{{ route('posts.index') }}"
            class="flex items-center gap-3 rounded-xl p-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
        >
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100">
                📚
            </span>

            Mes publications
        </a>

        <a
            href="{{ route('profile.edit') }}"
            class="flex items-center gap-3 rounded-xl p-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
        >
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100">
                👤
            </span>

            Mon profil
        </a>

        <a
            href="{{ route('home') }}"
            class="flex items-center gap-3 rounded-xl p-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
        >
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100">
                🔎
            </span>

            Découvrir Xaamlé
        </a>

    </div>

</section>