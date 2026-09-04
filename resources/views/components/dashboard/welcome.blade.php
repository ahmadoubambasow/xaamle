@props(['user'])

<section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="p-6 sm:p-8">

        <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-4">

                {{-- Avatar --}}
                <div class="h-16 w-16 shrink-0 overflow-hidden rounded-full">

                    @if ($user->avatar)

                        <x-cloudinary::image
                            public-id="{{ $user->avatar }}"
                            alt="Photo de {{ $user->name }}"
                            class="h-full w-full object-cover"
                        />

                    @else

                        <div class="flex h-full w-full items-center justify-center bg-gray-900 text-xl font-semibold text-white">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                    @endif

                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Bienvenue sur Xaamlé
                    </p>

                    @php
                        $hour = now()->hour;

                        $greeting = match (true) {
                            $hour < 12 => 'Bonjour',
                            $hour < 18 => 'Bon après-midi',
                            default => 'Bonsoir',
                        };
                    @endphp

                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900">
                        {{ $greeting }}, {{ $user->name }} 👋
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Heureux de vous retrouver.
                    </p>
                </div>

            </div>

            <a
                href="{{ route('posts.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800"
            >
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
                        d="M12 4.5v15m7.5-7.5h-15"
                    />
                </svg>

                Écrire une publication
            </a>

        </div>

    </div>

</section>