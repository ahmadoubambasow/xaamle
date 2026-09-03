<nav x-data="{ open: false }" class="border-b border-gray-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="relative flex h-16 items-center justify-between">

            {{-- Logo Xaamlé --}}
            <div class="flex items-center">
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
            </div>


            {{-- Navigation desktop centrée --}}
            <div class="absolute left-1/2 hidden -translate-x-1/2 items-center gap-8 sm:flex">

                <a
                    href="{{ route('dashboard') }}"
                    class="relative py-2 text-sm font-medium transition
                    {{ request()->routeIs('dashboard')
                        ? 'text-gray-900'
                        : 'text-gray-500 hover:text-gray-900' }}"
                >
                    Accueil

                    @if (request()->routeIs('dashboard'))
                        <span class="absolute inset-x-0 -bottom-1 h-0.5 rounded-full bg-gray-900"></span>
                    @endif
                </a>


                <a
                    href="{{ route('home') }}"
                    class="relative py-2 text-sm font-medium transition
                    {{ request()->routeIs('home') || request()->routeIs('public.posts.*')
                        ? 'text-gray-900'
                        : 'text-gray-500 hover:text-gray-900' }}"
                >
                    Publications

                    @if (request()->routeIs('home') || request()->routeIs('public.posts.*'))
                        <span class="absolute inset-x-0 -bottom-1 h-0.5 rounded-full bg-gray-900"></span>
                    @endif
                </a>


                <a
                    href="{{ route('posts.index') }}"
                    class="relative py-2 text-sm font-medium transition
                    {{ request()->routeIs('posts.*')
                        ? 'text-gray-900'
                        : 'text-gray-500 hover:text-gray-900' }}"
                >
                    Mes publications

                    @if (request()->routeIs('posts.*'))
                        <span class="absolute inset-x-0 -bottom-1 h-0.5 rounded-full bg-gray-900"></span>
                    @endif
                </a>

            </div>


            {{-- Menu utilisateur desktop --}}
            <div class="hidden sm:flex sm:items-center">

                <x-dropdown align="right" width="56">

                    <x-slot name="trigger">

                        <button
                            type="button"
                            class="inline-flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-gray-900 focus:outline-none"
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

                                    <div class="flex h-full w-full items-center justify-center bg-gray-900 text-sm font-semibold text-white">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>

                                @endif

                            </div>

                            {{-- Nom --}}
                            <div class="hidden text-left md:block">
                                <div class="text-sm font-semibold text-gray-800">
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


                    <x-slot name="content">

                        {{-- En-tête du menu --}}
                        <div class="border-b border-gray-100 px-4 py-3">

                            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                Compte
                            </p>

                            <p class="mt-1 truncate text-sm font-semibold text-gray-800">
                                {{ auth()->user()->name }}
                            </p>

                        </div>


                        {{-- Profil --}}
                        <x-dropdown-link :href="route('profile.edit')">

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
                        <form method="POST" action="{{ route('logout') }}">
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

            </div>


            {{-- Bouton mobile --}}
            <div class="flex items-center sm:hidden">

                <button
                    @click="open = !open"
                    class="inline-flex items-center justify-center rounded-xl p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none"
                >

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


    {{-- Navigation mobile --}}
    <div
        x-show="open"
        x-cloak
        x-transition
        class="border-t border-gray-100 sm:hidden"
    >

        <div class="space-y-1 px-4 pb-4 pt-3">

            <a
                href="{{ route('dashboard') }}"
                class="block rounded-xl px-4 py-3 text-sm font-medium
                {{ request()->routeIs('dashboard')
                    ? 'bg-gray-100 text-gray-900'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
            >
                Accueil
            </a>

            <a
                href="{{ route('posts.index') }}"
                class="block rounded-xl px-4 py-3 text-sm font-medium
                {{ request()->routeIs('public.posts.*')
                    ? 'bg-gray-100 text-gray-900'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
            >
                Publications
            </a>

            <a
                href="{{ route('posts.index') }}"
                class="block rounded-xl px-4 py-3 text-sm font-medium
                {{ request()->routeIs('posts.*')
                    ? 'bg-gray-100 text-gray-900'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
            >
                Mes publications
            </a>

        </div>


        {{-- Utilisateur mobile --}}
        <div class="border-t border-gray-100 px-4 py-4">

            <div class="flex items-center gap-3">

                {{-- Avatar --}}
                <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full">

                    @if (auth()->user()->avatar)

                        <img
                            src="{{ asset('storage/' . auth()->user()->avatar) }}"
                            alt="Photo de {{ auth()->user()->name }}"
                            class="h-full w-full object-cover"
                        >

                    @else

                        <div class="flex h-full w-full items-center justify-center bg-gray-900 text-sm font-semibold text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                    @endif

                </div>

                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-gray-800">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-gray-400">
                        Mon compte
                    </p>
                </div>

            </div>


            <div class="mt-3 space-y-1">

                <a
                    href="{{ route('profile.edit') }}"
                    class="block rounded-xl px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900"
                >
                    Mon profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="w-full rounded-xl px-4 py-3 text-left text-sm font-medium text-red-600 transition hover:bg-red-50"
                    >
                        Déconnexion
                    </button>
                </form>

            </div>

        </div>

    </div>

</nav>