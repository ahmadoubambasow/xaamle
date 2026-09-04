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

    {{-- Alpine.js --}}
    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
    ></script>

    {{-- Alpine : éviter le flash des éléments x-cloak --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    {{-- ========================================================= --}}
    {{-- DONNÉES DE NAVIGATION --}}
    {{-- ========================================================= --}}

    @auth
        @php
            $unreadNotificationsCount = auth()->user()
                ->unreadNotifications()
                ->count();

            $latestNotifications = auth()->user()
                ->notifications()
                ->latest()
                ->take(5)
                ->get();
        @endphp
    @endauth

    @stack('head')

</head>


<body class="min-h-screen bg-gray-50 font-sans text-gray-900 antialiased">

    {{-- ========================================================= --}}
    {{-- NAVIGATION --}}
    {{-- ========================================================= --}}

    <header
        x-data="{
            open: false,
            userMenu: false
        }"
        class="sticky top-0 z-40 border-b border-gray-200 bg-white/95 backdrop-blur"
    >

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="relative flex h-16 items-center justify-between">

                {{-- ================================================= --}}
                {{-- LOGO --}}
                {{-- ================================================= --}}

                <div class="shrink-0">

                    <a
                        href="{{ route('home') }}"
                        class="flex items-center gap-2"
                    >

                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-900 text-sm font-bold text-white"
                        >
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

                </div>


                {{-- ================================================= --}}
                {{-- NAVIGATION CENTRALE DESKTOP --}}
                {{-- ================================================= --}}

                <nav
                    class="absolute left-1/2 hidden -translate-x-1/2 items-center gap-8 md:flex"
                >

                    {{-- Accueil --}}

                    <a
                        href="{{ route('home') }}"
                        class="relative py-5 text-sm font-medium transition
                        {{ request()->routeIs('home') || request()->routeIs('public.posts.*')
                            ? 'text-gray-900'
                            : 'text-gray-500 hover:text-gray-900' }}"
                    >

                        Accueil

                        @if (
                            request()->routeIs('home') ||
                            request()->routeIs('public.posts.*')
                        )
                            <span
                                class="absolute inset-x-0 -bottom-1 h-0.5 rounded-full bg-gray-900"
                            ></span>
                        @endif

                    </a>


                    @auth

                        {{-- Mes publications --}}

                        <a
                            href="{{ route('posts.index') }}"
                            class="relative py-5 text-sm font-medium transition
                            {{ request()->routeIs('posts.*')
                                ? 'text-gray-900'
                                : 'text-gray-500 hover:text-gray-900' }}"
                        >

                            Mes publications

                            @if (request()->routeIs('posts.*'))
                                <span
                                    class="absolute inset-x-0 -bottom-1 h-0.5 rounded-full bg-gray-900"
                                ></span>
                            @endif

                        </a>


                        {{-- Écrire --}}

                        <a
                            href="{{ route('posts.create') }}"
                            class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800"
                        >
                            Écrire
                        </a>

                    @endauth

                </nav>


                {{-- ================================================= --}}
                {{-- PARTIE DROITE DESKTOP --}}
                {{-- ================================================= --}}

                <div class="hidden items-center md:flex">

                    @auth

                        {{-- ========================================= --}}
                        {{-- NOTIFICATIONS --}}
                        {{-- ========================================= --}}

                        <div
                            x-data="{ openNotifications: false }"
                            class="relative mr-2"
                        >

                            {{-- Bouton cloche --}}

                            <button
                                type="button"
                                @click="openNotifications = !openNotifications"
                                @click.outside="openNotifications = false"
                                class="relative flex h-10 w-10 items-center justify-center rounded-xl text-gray-500 transition hover:bg-gray-100 hover:text-gray-900"
                                aria-label="Notifications"
                                :aria-expanded="openNotifications.toString()"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 0 1-5.714 0A2.5 2.5 0 0 1 7 14.6V11a5 5 0 0 1 10 0v3.6a2.5 2.5 0 0 1-2.143 2.482ZM9.5 19a3 3 0 0 0 5 0"
                                    />
                                </svg>


                                {{-- Badge notifications non lues --}}

                                @if ($unreadNotificationsCount > 0)

                                    <span
                                        class="absolute right-0.5 top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-red-600 px-1 text-[9px] font-bold text-white ring-2 ring-white"
                                    >
                                        {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                                    </span>

                                @endif

                            </button>


                            {{-- ========================================= --}}
                            {{-- DROPDOWN NOTIFICATIONS --}}
                            {{-- ========================================= --}}

                            <div
                                x-show="openNotifications"
                                x-cloak
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 z-50 mt-3 w-80 origin-top-right overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl"
                            >

                                {{-- En-tête --}}

                                <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">

                                    <div>

                                        <h3 class="text-sm font-semibold text-gray-900">
                                            Notifications
                                        </h3>

                                        @if ($unreadNotificationsCount > 0)

                                            <p class="mt-0.5 text-xs text-gray-500">
                                                {{ $unreadNotificationsCount }}
                                                {{ $unreadNotificationsCount > 1 ? 'non lues' : 'non lue' }}
                                            </p>

                                        @else

                                            <p class="mt-0.5 text-xs text-gray-500">
                                                Tout est à jour
                                            </p>

                                        @endif

                                    </div>


                                    {{-- Tout lire --}}

                                    @if ($unreadNotificationsCount > 0)

                                        <form
                                            method="POST"
                                            action="{{ route('notifications.read-all') }}"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="text-xs font-semibold text-gray-500 transition hover:text-gray-900"
                                            >
                                                Tout lire
                                            </button>

                                        </form>

                                    @endif

                                </div>


                                {{-- Liste des notifications --}}

                                <div class="max-h-[380px] overflow-y-auto">

                                    @forelse ($latestNotifications as $notification)

                                        @php
                                            $data = $notification->data;
                                            $isUnread = is_null($notification->read_at);
                                            $type = $data['type'] ?? null;
                                        @endphp

                                        <div
                                            class="border-b border-gray-100 last:border-b-0
                                            {{ $isUnread ? 'bg-gray-50' : 'bg-white' }}"
                                        >

                                            <form
                                                method="POST"
                                                action="{{ route('notifications.read', $notification->id) }}"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="flex w-full items-start gap-3 px-4 py-3 text-left transition hover:bg-gray-50"
                                                >

                                                    {{-- Icône --}}

                                                    <div
                                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full
                                                        {{ $type === 'post_liked'
                                                            ? 'bg-red-50'
                                                            : 'bg-blue-50' }}"
                                                    >

                                                        @if ($type === 'post_liked')

                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-red-500"
                                                                viewBox="0 0 24 24"
                                                                fill="currentColor"
                                                            >
                                                                <path
                                                                    d="M12 21s-7.5-4.35-9.33-8.15C1.22 9.82 3.03 5.5 7.2 5.5c2.08 0 3.62 1.16 4.8 2.57C13.18 6.66 14.72 5.5 16.8 5.5c4.17 0 5.98 4.32 4.53 7.35C19.5 16.65 12 21 12 21Z"
                                                                />
                                                            </svg>

                                                        @else

                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-blue-600"
                                                                fill="none"
                                                                viewBox="0 0 24 24"
                                                                stroke="currentColor"
                                                                stroke-width="1.8"
                                                            >
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    d="M21 11.5a8.38 8.38 0 0 1-9 8.5 8.5 8.5 0 0 1-4.36-1.2L3 20l1.2-4.64A8.5 8.5 0 1 1 21 11.5Z"
                                                                />
                                                            </svg>

                                                        @endif

                                                    </div>


                                                    {{-- Contenu --}}

                                                    <div class="min-w-0 flex-1">

                                                        <p class="text-xs leading-5 text-gray-700">
                                                            {{ $data['message'] ?? 'Nouvelle notification.' }}
                                                        </p>

                                                        @if (!empty($data['post_title']))

                                                            <p class="mt-0.5 truncate text-xs font-semibold text-gray-900">
                                                                {{ $data['post_title'] }}
                                                            </p>

                                                        @endif

                                                        <p class="mt-1 text-[11px] text-gray-400">
                                                            {{ $notification->created_at->diffForHumans() }}
                                                        </p>

                                                    </div>


                                                    {{-- Point notification non lue --}}

                                                    @if ($isUnread)

                                                        <span
                                                            class="mt-2 h-2 w-2 shrink-0 rounded-full bg-gray-900"
                                                        ></span>

                                                    @endif

                                                </button>

                                            </form>

                                        </div>

                                    @empty

                                        <div class="px-5 py-10 text-center">

                                            <div
                                                class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-gray-100"
                                            >

                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-gray-400"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M14.857 17.082a23.848 23.848 0 0 1-5.714 0A2.5 2.5 0 0 1 7 14.6V11a5 5 0 0 1 10 0v3.6a2.5 2.5 0 0 1-2.143 2.482ZM9.5 19a3 3 0 0 0 5 0"
                                                    />
                                                </svg>

                                            </div>

                                            <p class="mt-3 text-sm font-semibold text-gray-900">
                                                Aucune notification
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                                Les likes et commentaires apparaîtront ici.
                                            </p>

                                        </div>

                                    @endforelse

                                </div>


                                {{-- Footer --}}

                                <div class="border-t border-gray-100 bg-gray-50 px-4 py-3 text-center">

                                    <a
                                        href="{{ route('notifications.index') }}"
                                        class="text-xs font-semibold text-gray-700 transition hover:text-gray-900"
                                    >
                                        Voir toutes les notifications →
                                    </a>

                                </div>

                            </div>

                        </div>


                        {{-- ========================================= --}}
                        {{-- DROPDOWN UTILISATEUR --}}
                        {{-- ========================================= --}}

                        <div class="relative">

                            <button
                                type="button"
                                @click="userMenu = !userMenu"
                                @click.outside="userMenu = false"
                                class="flex items-center gap-3 rounded-lg px-2 py-2 transition hover:bg-gray-100"
                            >

                                {{-- Avatar --}}

                                <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full">

                                    @if (auth()->user()->avatar)

                                        <img
                                            src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                            alt="Photo de {{ auth()->user()->name }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <div
                                            class="flex h-full w-full items-center justify-center bg-gray-900 text-sm font-semibold text-white"
                                        >
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>

                                    @endif

                                </div>


                                {{-- Nom --}}

                                <div class="hidden text-left lg:block">

                                    <p class="max-w-32 truncate text-sm font-semibold text-gray-900">
                                        {{ auth()->user()->name }}
                                    </p>

                                </div>


                                {{-- Chevron --}}

                                <svg
                                    class="h-4 w-4 text-gray-400 transition-transform"
                                    :class="{ 'rotate-180': userMenu }"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5"
                                    />
                                </svg>

                            </button>


                            {{-- Dropdown --}}

                            <div
                                x-show="userMenu"
                                x-transition
                                x-cloak
                                class="absolute right-0 mt-2 w-56 origin-top-right rounded-xl border border-gray-200 bg-white py-2 shadow-lg"
                            >

                                {{-- Informations utilisateur --}}

                                <div class="border-b border-gray-100 px-4 py-3">

                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ auth()->user()->name }}
                                    </p>

                                    <p class="mt-0.5 truncate text-xs text-gray-500">
                                        {{ auth()->user()->email }}
                                    </p>

                                </div>


                                {{-- Profil --}}

                                @if (Route::has('profile.edit'))

                                    <a
                                        href="{{ route('profile.edit') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-50"
                                    >

                                        <svg
                                            class="h-4 w-4 text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
                                            />
                                        </svg>

                                        Mon profil

                                    </a>

                                @endif


                                {{-- Notifications --}}

                                <a
                                    href="{{ route('notifications.index') }}"
                                    class="flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-50"
                                >

                                    <div class="flex items-center gap-3">

                                        <svg
                                            class="h-4 w-4 text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M14.857 17.082a23.848 23.848 0 0 1-5.714 0A2.5 2.5 0 0 1 7 14.6V11a5 5 0 0 1 10 0v3.6a2.5 2.5 0 0 1-2.143 2.482ZM9.5 19a3 3 0 0 0 5 0"
                                            />
                                        </svg>

                                        Notifications

                                    </div>

                                    @if ($unreadNotificationsCount > 0)

                                        <span
                                            class="flex min-w-5 items-center justify-center rounded-full bg-red-600 px-1.5 py-0.5 text-[10px] font-bold text-white"
                                        >
                                            {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                                        </span>

                                    @endif

                                </a>


                                {{-- Mes publications --}}

                                <a
                                    href="{{ route('posts.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-50"
                                >

                                    <svg
                                        class="h-4 w-4 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25"
                                        />
                                    </svg>

                                    Mes publications

                                </a>


                                {{-- Écrire --}}

                                <a
                                    href="{{ route('posts.create') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 transition hover:bg-gray-50"
                                >

                                    <svg
                                        class="h-4 w-4 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14.25v4.125A2.625 2.625 0 0 1 15.375 21H5.625A2.625 2.625 0 0 1 3 18.375V8.625A2.625 2.625 0 0 1 5.625 6H9.75"
                                        />
                                    </svg>

                                    Écrire une publication

                                </a>


                                {{-- Déconnexion --}}

                                <div class="my-1 border-t border-gray-100"></div>

                                <form
                                    method="POST"
                                    action="{{ route('logout') }}"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 transition hover:bg-red-50"
                                    >

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
                                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3-6-3 3m0 0 3 3m-3-3h9"
                                            />
                                        </svg>

                                        Déconnexion

                                    </button>

                                </form>

                            </div>

                        </div>

                    @else

                        {{-- Visiteur --}}

                        <div class="flex items-center gap-4">

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

                        </div>

                    @endauth

                </div>


                {{-- ================================================= --}}
                {{-- BOUTON MOBILE --}}
                {{-- ================================================= --}}

                <button
                    type="button"
                    @click="open = !open"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 md:hidden"
                    aria-label="Ouvrir le menu"
                >

                    {{-- Menu --}}

                    <svg
                        x-show="!open"
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                        />
                    </svg>


                    {{-- Fermer --}}

                    <svg
                        x-show="open"
                        x-cloak
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18 18 6M6 6l12 12"
                        />
                    </svg>

                </button>

            </div>


            {{-- ================================================= --}}
            {{-- MENU MOBILE --}}
            {{-- ================================================= --}}

            <div
                x-show="open"
                x-transition
                x-cloak
                class="border-t border-gray-100 py-4 md:hidden"
            >

                <div class="space-y-1">

                    {{-- Accueil --}}

                    <a
                        href="{{ route('home') }}"
                        class="block rounded-lg px-4 py-3 text-sm font-medium
                        {{ request()->routeIs('home') || request()->routeIs('public.posts.*')
                            ? 'bg-gray-100 text-gray-900'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                    >
                        Accueil
                    </a>


                    @auth

                        {{-- Mes publications --}}

                        <a
                            href="{{ route('posts.index') }}"
                            class="block rounded-lg px-4 py-3 text-sm font-medium
                            {{ request()->routeIs('posts.*')
                                ? 'bg-gray-100 text-gray-900'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                        >
                            Mes publications
                        </a>


                        {{-- Notifications --}}

                        <a
                            href="{{ route('notifications.index') }}"
                            class="flex items-center justify-between rounded-lg px-4 py-3 text-sm font-medium
                            {{ request()->routeIs('notifications.*')
                                ? 'bg-gray-100 text-gray-900'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                        >

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl
                                    {{ request()->routeIs('notifications.*')
                                        ? 'bg-gray-900 text-white'
                                        : 'bg-gray-100 text-gray-600' }}"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 0 1-5.714 0A2.5 2.5 0 0 1 7 14.6V11a5 5 0 0 1 10 0v3.6a2.5 2.5 0 0 1-2.143 2.482ZM9.5 19a3 3 0 0 0 5 0"
                                        />
                                    </svg>

                                </div>

                                <span>
                                    Notifications
                                </span>

                            </div>


                            @if ($unreadNotificationsCount > 0)

                                <span
                                    class="flex min-w-5 items-center justify-center rounded-full bg-red-600 px-1.5 py-0.5 text-[10px] font-bold text-white"
                                >
                                    {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                                </span>

                            @endif

                        </a>


                        {{-- Écrire --}}

                        <a
                            href="{{ route('posts.create') }}"
                            class="block rounded-lg px-4 py-3 text-sm font-semibold text-gray-900 hover:bg-gray-50"
                        >
                            + Écrire une publication
                        </a>


                        {{-- Séparateur --}}

                        <div class="my-3 border-t border-gray-100"></div>


                        {{-- Profil --}}

                        @if (Route::has('profile.edit'))

                            <a
                                href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm text-gray-600 hover:bg-gray-50"
                            >

                                {{-- Avatar --}}

                                <div class="h-8 w-8 shrink-0 overflow-hidden rounded-full">

                                    @if (auth()->user()->avatar)

                                        <img
                                            src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                            alt="Photo de {{ auth()->user()->name }}"
                                            class="h-full w-full object-cover"
                                        >

                                    @else

                                        <div
                                            class="flex h-full w-full items-center justify-center bg-gray-900 text-xs font-semibold text-white"
                                        >
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>

                                    @endif

                                </div>


                                <div>

                                    <p class="font-medium text-gray-900">
                                        {{ auth()->user()->name }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        Mon profil
                                    </p>

                                </div>

                            </a>

                        @endif


                        {{-- Déconnexion --}}

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="w-full rounded-lg px-4 py-3 text-left text-sm font-medium text-red-600 hover:bg-red-50"
                            >
                                Déconnexion
                            </button>

                        </form>

                    @else

                        {{-- Connexion --}}

                        <a
                            href="{{ route('login') }}"
                            class="block rounded-lg px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                        >
                            Connexion
                        </a>


                        {{-- Inscription --}}

                        <a
                            href="{{ route('register') }}"
                            class="mt-2 block rounded-lg bg-gray-900 px-4 py-3 text-center text-sm font-semibold text-white hover:bg-gray-800"
                        >
                            Rejoindre Xaamlé
                        </a>

                    @endauth

                </div>

            </div>

        </div>

    </header>


    {{-- ========================================================= --}}
    {{-- CONTENU --}}
    {{-- ========================================================= --}}

    <main>
        @yield('content')
    </main>


    {{-- ========================================================= --}}
    {{-- FOOTER --}}
    {{-- ========================================================= --}}

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
