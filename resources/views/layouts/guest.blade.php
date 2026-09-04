<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ config('app.name', 'Xaamlé') }}
    </title>

    <meta
        name="description"
        content="Xaamlé — Faire savoir, partager et échanger."
    >

    <link rel="icon" type="image/ico" href="{{ asset('favicon.ico') }}?v=2">


    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap"
        rel="stylesheet"
    >

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: [
                            'Figtree',
                            'ui-sans-serif',
                            'system-ui',
                            'sans-serif'
                        ],
                    },
                },
            },
        };
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-gray-50 font-sans text-gray-900 antialiased">

    <div class="flex min-h-screen flex-col">


        {{-- =========================
             HEADER
        ========================== --}}
        <header class="border-b border-gray-200 bg-white">

            <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

                {{-- Logo --}}
                <a
                    href="{{ route('home') }}"
                    class="group flex items-center gap-3"
                >

                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-900 text-sm font-bold text-white transition group-hover:bg-gray-700"
                    >
                        X
                    </div>

                    <div class="leading-tight">

                        <div class="text-lg font-bold tracking-tight text-gray-900">
                            Xaamlé
                        </div>

                        <div class="hidden text-[11px] text-gray-400 sm:block">
                            Faire savoir
                        </div>

                    </div>

                </a>


                {{-- Retour accueil --}}
                <a
                    href="{{ route('home') }}"
                    class="text-sm font-medium text-gray-500 transition hover:text-gray-900"
                >
                    ← Accueil
                </a>

            </div>

        </header>



        {{-- =========================
             CONTENT
        ========================== --}}
        <main class="flex flex-1 items-center justify-center px-4 py-12 sm:px-6">

            <div class="w-full max-w-md">

                {{-- Introduction --}}
                <div class="mb-8 text-center">

                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-900 text-lg font-bold text-white shadow-sm"
                    >
                        X
                    </div>

                    <h1 class="mt-5 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                        {{ $title ?? 'Bienvenue sur Xaamlé' }}
                    </h1>

                    <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-gray-500">
                        Partagez vos idées, vos connaissances et vos expériences avec la communauté.
                    </p>

                </div>


                {{-- Auth Card --}}
                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="p-6 sm:p-8">

                        {{ $slot }}

                    </div>

                </div>


                {{-- Footer --}}
                <p class="mt-8 text-center text-xs text-gray-400">
                    © {{ date('Y') }} Xaamlé · Faire savoir.
                </p>

            </div>

        </main>

    </div>

</body>

</html>