<section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="px-6 py-8 text-center sm:px-8">

        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-900 text-xl">
            ✨
        </div>

        <h2 class="mt-4 text-lg font-semibold text-gray-900">
            Une idée à partager ?
        </h2>

        <p class="mx-auto mt-2 max-w-lg text-sm leading-6 text-gray-500">
            Votre expérience peut être utile à quelqu'un.
            Partagez ce que vous savez et faites-le savoir avec Xaamlé.
        </p>

        <a
            href="{{ route('posts.create') }}"
            class="mt-5 inline-flex items-center gap-2 rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
        >
            Écrire une publication

            <svg
                class="h-4 w-4"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                />
            </svg>

        </a>

    </div>

</section>