<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $title ?? 'Xaamlé — Faire savoir' }}
    </title>

    <meta
        name="description"
        content="{{ $description ?? 'Xaamlé — Une communauté pour partager des idées, des connaissances et des expériences.' }}"
    >

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: [
                            'Inter',
                            'ui-sans-serif',
                            'system-ui',
                            'sans-serif'
                        ],
                    },
                },
            },
        };
    </script>

    @stack('head')

</head>

<body class="min-h-screen bg-gray-50 font-sans text-gray-900 antialiased">

    {{-- Navigation --}}
    <header class="sticky top-0 z-40 border-b border-gray-200 bg-white/95 backdrop-blur">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="flex h-16 items-center justify-between">

                {{-- Logo --}}
                <a
                    href="{{ route('home') }}"
                    class="flex items-center gap-2"
                >
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-900 text-sm font-bold text-white">
                        X
                    </div>

                    <div>
                        <span class="text-lg font-bold tracking-tight text-gray-900">
                            Xaamlé
                        </span>

                        <span class="ml-1 hidden text-xs text-gray-400 sm:inline">
                            Faire savoir
                        </span>
                    </div>
                </a>


                {{-- Navigation desktop --}}
                <nav class="hidden items-center gap-6 md:flex">

                    <a
                        href="{{ route('home') }}"
                        class="text-sm font-medium text-gray-600 transition hover:text-gray-900"
                    >
                        Accueil
                    </a>

                    @auth

                        <a
                            href="{{ route('posts.index') }}"
                            class="text-sm font-medium text-gray-600 transition hover:text-gray-900"
                        >
                            Mes publications
                        </a>

                        <a
                            href="{{ route('posts.create') }}"
                            class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800"
                        >
                            Écrire
                        </a>

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-600 transition hover:text-gray-900"
                        >
                            Connexion
                        </a>

                        <a
                            href="{{ route('register') }}"
                            class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800"
                        >
                            Rejoindre Xaamlé
                        </a>

                    @endauth

                </nav>


                {{-- Navigation mobile --}}
                <div class="md:hidden">

                    @auth

                        <a
                            href="{{ route('posts.create') }}"
                            class="inline-flex items-center rounded-lg bg-gray-900 px-3 py-2 text-sm font-semibold text-white"
                        >
                            + Écrire
                        </a>

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="text-sm font-semibold text-gray-700"
                        >
                            Connexion
                        </a>

                    @endauth

                </div>

            </div>

        </div>

    </header>


    {{-- Contenu --}}
    <main>
        @yield('content')
    </main>


    {{-- Footer --}}
    <footer class="border-t border-gray-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <p class="font-bold text-gray-900">
                        Xaamlé
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        Faire savoir. Partager. Construire une communauté.
                    </p>

                </div>


                <div class="text-sm text-gray-400">
                    © {{ date('Y') }} Xaamlé
                </div>

            </div>

        </div>

    </footer>


    @stack('scripts')

</body>

</html>