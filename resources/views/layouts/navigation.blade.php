<nav
    x-data="{ open: false }"
    class="border-b border-gray-200 bg-white"
>

    {{-- =========================================================
         DONNÉES DES NOTIFICATIONS
    ========================================================== --}}

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


    {{-- =========================================================
         CONTENEUR PRINCIPAL
    ========================================================== --}}

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="relative flex h-16 items-center justify-between">


            {{-- =====================================================
                 LOGO
            ====================================================== --}}

            <div class="flex items-center">

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

                        <span
                            class="text-lg font-bold tracking-tight text-gray-900"
                        >
                            Xaamlé
                        </span>

                        <span
                            class="ml-1 hidden text-xs text-gray-400 sm:inline"
                        >
                            Faire savoir
                        </span>

                    </div>

                </a>

            </div>


            {{-- =====================================================
                 NAVIGATION DESKTOP
            ====================================================== --}}

            <div
                class="absolute left-1/2 hidden -translate-x-1/2 items-center gap-8 sm:flex"
            >

                {{-- Accueil --}}
                @auth

                    <a
                        href="{{ route('dashboard') }}"
                        class="relative py-2 text-sm font-medium transition
                        {{ request()->routeIs('dashboard')
                            ? 'text-gray-900'
                            : 'text-gray-500 hover:text-gray-900' }}"
                    >

                        Accueil

                        @if (request()->routeIs('dashboard'))

                            <span
                                class="absolute inset-x-0 -bottom-1 h-0.5 rounded-full bg-gray-900"
                            ></span>

                        @endif

                    </a>

                @endauth


                {{-- Publications --}}
                <a
                    href="{{ route('home') }}"
                    class="relative py-2 text-sm font-medium transition
                    {{ request()->routeIs('home') || request()->routeIs('public.posts.*')
                        ? 'text-gray-900'
                        : 'text-gray-500 hover:text-gray-900' }}"
                >

                    Publications

                    @if (
                        request()->routeIs('home') ||
                        request()->routeIs('public.posts.*')
                    )

                        <span
                            class="absolute inset-x-0 -bottom-1 h-0.5 rounded-full bg-gray-900"
                        ></span>

                    @endif

                </a>


                {{-- Mes publications --}}
                @auth

                    <a
                        href="{{ route('posts.index') }}"
                        class="relative py-2 text-sm font-medium transition
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

                @endauth

            </div>


            {{-- =====================================================
                 ZONE UTILISATEUR DESKTOP
            ====================================================== --}}

            <div class="hidden items-center sm:flex">

                @auth


                    {{-- =================================================
                         NOTIFICATIONS DESKTOP
                    ================================================== --}}

                    <div
                        x-data="{ openNotifications: false }"
                        class="relative mr-2"
                    >

                        {{-- Bouton cloche --}}
                        <button
                            type="button"
                            @click="openNotifications = !openNotifications"
                            @click.outside="openNotifications = false"
                            class="relative flex h-10 w-10 items-center justify-center rounded-xl text-gray-500 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none"
                            aria-label="Notifications"
                            :aria-expanded="openNotifications.toString()"
                        >

                            {{-- Icône cloche --}}
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


                            {{-- Badge --}}
                            @if ($unreadNotificationsCount > 0)

                                <span
                                    class="absolute right-0.5 top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-red-600 px-1 text-[9px] font-bold text-white ring-2 ring-white"
                                >
                                    {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                                </span>

                            @endif

                        </button>


                        {{-- =================================================
                             DROPDOWN NOTIFICATIONS
                        ================================================== --}}

                        <div
                            x-show="openNotifications"
                            x-cloak
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="scale-95 opacity-0"
                            x-transition:enter-end="scale-100 opacity-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="scale-100 opacity-100"
                            x-transition:leave-end="scale-95 opacity-0"
                            class="absolute right-0 z-50 mt-3 w-80 origin-top-right overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl"
                        >

                            {{-- En-tête --}}
                            <div
                                class="flex items-center justify-between border-b border-gray-100 px-4 py-3"
                            >

                                <div>

                                    <h3
                                        class="text-sm font-semibold text-gray-900"
                                    >
                                        Notifications
                                    </h3>

                                    @if ($unreadNotificationsCount > 0)

                                        <p class="mt-0.5 text-xs text-gray-500">

                                            {{ $unreadNotificationsCount }}

                                            {{ $unreadNotificationsCount > 1
                                                ? 'non lues'
                                                : 'non lue' }}

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
                                        {{ $isUnread
                                            ? 'bg-gray-50'
                                            : 'bg-white' }}"
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

                                                        {{-- Like --}}
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

                                                        {{-- Commentaire --}}
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

                                                    <p
                                                        class="text-xs leading-5 text-gray-700"
                                                    >
                                                        {{ $data['message'] ?? 'Nouvelle notification.' }}
                                                    </p>


                                                    @if (!empty($data['post_title']))

                                                        <p
                                                            class="mt-0.5 truncate text-xs font-semibold text-gray-900"
                                                        >
                                                            {{ $data['post_title'] }}
                                                        </p>

                                                    @endif


                                                    <p
                                                        class="mt-1 text-[11px] text-gray-400"
                                                    >
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

                                    {{-- État vide --}}
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


                                        <p
                                            class="mt-3 text-sm font-semibold text-gray-900"
                                        >
                                            Aucune notification
                                        </p>


                                        <p
                                            class="mt-1 text-xs leading-5 text-gray-500"
                                        >
                                            Les likes et commentaires apparaîtront ici.
                                        </p>

                                    </div>

                                @endforelse

                            </div>


                            {{-- Footer --}}
                            <div
                                class="border-t border-gray-100 bg-gray-50 px-4 py-3 text-center"
                            >

                                <a
                                    href="{{ route('notifications.index') }}"
                                    class="text-xs font-semibold text-gray-700 transition hover:text-gray-900"
                                >
                                    Voir toutes les notifications →
                                </a>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         MENU UTILISATEUR DESKTOP
                    ================================================== --}}

                    <x-dropdown
                        align="right"
                        width="56"
                    >

                        {{-- Trigger --}}
                        <x-slot name="trigger">

                            <button
                                type="button"
                                class="inline-flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none"
                            >

                                {{-- Avatar --}}
                                <div
                                    class="h-9 w-9 shrink-0 overflow-hidden rounded-full"
                                >

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
                                <div class="hidden text-left md:block">

                                    <div
                                        class="text-sm font-semibold text-gray-800"
                                    >
                                        {{ auth()->user()->name }}
                                    </div>

                                    <div class="text-xs text-gray-400">
                                        Mon compte
                                    </div>

                                </div>


                                {{-- Chevron --}}
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
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5"
                                    />

                                </svg>

                            </button>

                        </x-slot>


                        {{-- Contenu --}}
                        <x-slot name="content">

                            {{-- En-tête --}}
                            <div
                                class="border-b border-gray-100 px-4 py-3"
                            >

                                <p
                                    class="text-xs font-medium uppercase tracking-wide text-gray-400"
                                >
                                    Compte
                                </p>

                                <p
                                    class="mt-1 truncate text-sm font-semibold text-gray-800"
                                >
                                    {{ auth()->user()->name }}
                                </p>

                            </div>


                            {{-- Profil --}}
                            <x-dropdown-link
                                :href="route('profile.edit')"
                            >

                                <div class="flex items-center gap-3">

                                    <svg
                                        class="h-5 w-5 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.5-1.632Z"
                                        />

                                    </svg>

                                    <span>
                                        Mon profil
                                    </span>

                                </div>

                            </x-dropdown-link>


                            {{-- Déconnexion --}}
                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                            >

                                @csrf

                                <x-dropdown-link
                                    :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-600 hover:bg-red-50 hover:text-red-700"
                                >

                                    <div class="flex items-center gap-3">

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
                                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M18 12H9m0 0 3-3m-3 3 3 3"
                                            />

                                        </svg>

                                        <span>
                                            Déconnexion
                                        </span>

                                    </div>

                                </x-dropdown-link>

                            </form>

                        </x-slot>

                    </x-dropdown>


                @else

                    {{-- =================================================
                         VISITEUR DESKTOP
                    ================================================== --}}

                    <div class="flex items-center gap-2">

                        <a
                            href="{{ route('login') }}"
                            class="rounded-xl px-4 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-gray-900"
                        >
                            Connexion
                        </a>


                        @if (Route::has('register'))

                            <a
                                href="{{ route('register') }}"
                                class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800"
                            >
                                Inscription
                            </a>

                        @endif

                    </div>

                @endauth

            </div>


            {{-- =====================================================
                 BOUTON MOBILE
            ====================================================== --}}

            <div class="flex items-center sm:hidden">

                <button
                    type="button"
                    @click="open = !open"
                    class="inline-flex items-center justify-center rounded-xl p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none"
                    :aria-expanded="open.toString()"
                    aria-label="Ouvrir le menu"
                >

                    {{-- Menu --}}
                    <svg
                        x-show="!open"
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

        </div>

    </div>


    {{-- =========================================================
         NAVIGATION MOBILE
    ========================================================== --}}

    <div
        x-show="open"
        x-cloak
        x-transition
        class="border-t border-gray-100 sm:hidden"
    >

        {{-- =====================================================
             LIENS DE NAVIGATION
        ====================================================== --}}

        <div class="space-y-1 px-4 pb-4 pt-3">

            {{-- Accueil --}}
            @auth

                <a
                    href="{{ route('dashboard') }}"
                    class="block rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('dashboard')
                        ? 'bg-gray-100 text-gray-900'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                >
                    Accueil
                </a>

            @endauth


            {{-- Publications --}}
            <a
                href="{{ route('home') }}"
                class="block rounded-xl px-4 py-3 text-sm font-medium transition
                {{ request()->routeIs('home') || request()->routeIs('public.posts.*')
                    ? 'bg-gray-100 text-gray-900'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
            >
                Publications
            </a>


            {{-- Mes publications --}}
            @auth

                <a
                    href="{{ route('posts.index') }}"
                    class="block rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('posts.*')
                        ? 'bg-gray-100 text-gray-900'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                >
                    Mes publications
                </a>

            @endauth


            {{-- =================================================
                 NOTIFICATIONS MOBILE
            ================================================== --}}

            @auth

                <a
                    href="{{ route('notifications.index') }}"
                    class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium transition
                    {{ request()->routeIs('notifications.*')
                        ? 'bg-gray-100 text-gray-900'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
                >

                    <div class="flex items-center gap-3">

                        {{-- Icône --}}
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


                    {{-- Badge --}}
                    @if ($unreadNotificationsCount > 0)

                        <span
                            class="flex min-w-5 items-center justify-center rounded-full bg-red-600 px-1.5 py-0.5 text-[10px] font-bold text-white"
                        >
                            {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                        </span>

                    @endif

                </a>

            @endauth

        </div>


        {{-- =====================================================
             UTILISATEUR MOBILE
        ====================================================== --}}

        <div class="border-t border-gray-100 px-4 py-4">

            @auth

                {{-- =================================================
                     INFORMATIONS UTILISATEUR
                ================================================== --}}

                <div class="flex items-center gap-3">

                    {{-- Avatar --}}
                    <div
                        class="h-10 w-10 shrink-0 overflow-hidden rounded-full"
                    >

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


                    {{-- Informations --}}
                    <div class="min-w-0">

                        <p
                            class="truncate text-sm font-semibold text-gray-800"
                        >
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-xs text-gray-400">
                            Mon compte
                        </p>

                    </div>

                </div>


                {{-- =================================================
                     ACTIONS MOBILE
                ================================================== --}}

                <div class="mt-3 space-y-1">

                    {{-- Profil --}}
                    <a
                        href="{{ route('profile.edit') }}"
                        class="block rounded-xl px-4 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-gray-900"
                    >
                        Mon profil
                    </a>


                    {{-- Déconnexion --}}
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="w-full rounded-xl px-4 py-3 text-left text-sm font-medium text-red-600 transition hover:bg-red-50"
                        >
                            Déconnexion
                        </button>

                    </form>

                </div>

            @else

                {{-- =================================================
                     VISITEUR MOBILE
                ================================================== --}}

                <div class="space-y-1">

                    <a
                        href="{{ route('login') }}"
                        class="block rounded-xl px-4 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-gray-900"
                    >
                        Connexion
                    </a>


                    @if (Route::has('register'))

                        <a
                            href="{{ route('register') }}"
                            class="block rounded-xl bg-gray-900 px-4 py-3 text-center text-sm font-medium text-white transition hover:bg-gray-800"
                        >
                            Inscription
                        </a>

                    @endif

                </div>

            @endauth

        </div>

    </div>

</nav>


{{-- =============================================================
     ALPINE : x-cloak
============================================================= --}}

<style>
    [x-cloak] {
        display: none !important;
    }
</style>