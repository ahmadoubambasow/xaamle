<x-app-layout>

<x-slot name="header">
    <div>
        <h2 class="text-xl font-semibold tracking-tight text-gray-900">
            Notifications
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Les dernières interactions avec vos publications.
        </p>
    </div>
</x-slot>

<div class="min-h-screen bg-gray-50 py-8 sm:py-10">

    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

        {{-- En-tête --}}
        <div class="mb-6 flex items-center justify-between gap-4">

            <div>
                <h1 class="text-lg font-semibold text-gray-900">
                    Vos notifications
                </h1>

                @php
                    $unreadCount = auth()->user()
                        ->unreadNotifications()
                        ->count();
                @endphp

                <p class="mt-1 text-sm text-gray-500">
                    {{ $unreadCount }}
                    {{ $unreadCount > 1 ? 'notifications non lues' : 'notification non lue' }}
                </p>
            </div>

            @if ($unreadCount > 0)

                <form
                    method="POST"
                    action="{{ route('notifications.read-all') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                    >
                        Tout marquer comme lu
                    </button>
                </form>

            @endif

        </div>


        {{-- Liste --}}
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            @forelse ($notifications as $notification)

                @php
                    $data = $notification->data;
                    $isUnread = is_null($notification->read_at);
                    $type = $data['type'] ?? null;
                @endphp

                <div
                    class="border-b border-gray-100 last:border-b-0
                    {{ $isUnread ? 'bg-gray-50/70' : 'bg-white' }}"
                >

                    <div class="flex items-start gap-4 px-5 py-5 sm:px-6">

                        {{-- Icône --}}
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full
                            {{ $type === 'post_liked'
                                ? 'bg-red-50'
                                : 'bg-blue-50' }}"
                        >
                            @if ($type === 'post_liked')

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-red-500"
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
                                    class="h-5 w-5 text-blue-600"
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

                            <div class="flex items-start justify-between gap-3">

                                <div class="min-w-0">

                                    <p class="text-sm leading-6 text-gray-700">
                                        {{ $data['message'] ?? 'Nouvelle notification.' }}
                                    </p>

                                    @if (!empty($data['post_id']))

                                        <a
                                            href="{{ route('public.posts.show', $data['post_id']) }}"
                                            class="mt-1 block truncate text-sm font-semibold text-gray-900 transition hover:text-gray-600"
                                        >
                                            {{ $data['post_title'] ?? 'Voir la publication' }}
                                        </a>

                                    @endif

                                    <p class="mt-1 text-xs text-gray-400">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>

                                </div>


                                {{-- Indicateur non lu --}}
                                @if ($isUnread)

                                    <span
                                        class="mt-2 h-2.5 w-2.5 shrink-0 rounded-full bg-gray-900"
                                        title="Notification non lue"
                                    ></span>

                                @endif

                            </div>


                            {{-- Actions --}}
                            <div class="mt-3 flex items-center gap-3">

                                @if (!empty($data['post_id']))

                                    <a
                                        href="{{ route('public.posts.show', $data['post_id']) }}"
                                        class="text-xs font-semibold text-gray-600 transition hover:text-gray-900"
                                    >
                                        Voir la publication →
                                    </a>

                                @endif

                                @if ($isUnread)

                                    <form
                                        method="POST"
                                        action="{{ route('notifications.read', $notification->id) }}"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="text-xs font-medium text-gray-400 transition hover:text-gray-700"
                                        >
                                            Marquer comme lu
                                        </button>
                                    </form>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                {{-- État vide --}}
                <div class="px-6 py-16 text-center">

                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-gray-400"
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

                    <h2 class="mt-4 text-sm font-semibold text-gray-900">
                        Aucune notification
                    </h2>

                    <p class="mx-auto mt-1 max-w-sm text-sm leading-6 text-gray-500">
                        Les likes et commentaires reçus sur vos publications apparaîtront ici.
                    </p>

                </div>

            @endforelse

        </section>


        {{-- Pagination --}}
        @if ($notifications->hasPages())

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>

        @endif

    </div>

</div>

</x-app-layout>
