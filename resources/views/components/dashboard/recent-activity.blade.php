@props(['activities'])

<section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

    <h2 class="text-base font-semibold text-gray-900">
        Activité récente
    </h2>

    <p class="mt-1 text-sm text-gray-500">
        Ce qui se passe autour de vos publications.
    </p>

    <div class="mt-5">

        @forelse ($activities as $activity)

            <div class="flex items-start gap-3 border-b border-gray-100 py-4 last:border-0">

                {{-- Avatar --}}
                <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full">

                    @if ($activity['user']->avatar)

                        <x-cloudinary::image
                            public-id="{{ $activity['user']->avatar }}"
                            alt="Photo de {{ $activity['user']->name }}"
                            class="h-full w-full object-cover"
                        />

                    @else

                        <div class="flex h-full w-full items-center justify-center bg-gray-900 text-xs font-semibold text-white">
                            {{ strtoupper(substr($activity['user']->name, 0, 1)) }}
                        </div>

                    @endif

                </div>

                <div class="min-w-0 flex-1">

                    @if ($activity['type'] === 'like')

                        <p class="text-sm text-gray-700">
                            <span class="font-semibold text-gray-900">
                                {{ $activity['user']->name }}
                            </span>

                            a aimé votre publication.
                        </p>

                    @elseif ($activity['type'] === 'comment')

                        <p class="text-sm text-gray-700">
                            <span class="font-semibold text-gray-900">
                                {{ $activity['user']->name }}
                            </span>

                            a commenté votre publication.
                        </p>

                    @elseif ($activity['type'] === 'follow')

                        <p class="text-sm text-gray-700">
                            <span class="font-semibold text-gray-900">
                                {{ $activity['user']->name }}
                            </span>

                            vous suit maintenant.
                        </p>

                    @endif

                    @if ($activity['post'])

                        <p class="mt-0.5 truncate text-xs text-gray-500">
                            « {{ $activity['post']->title }} »
                        </p>

                    @endif

                    <p class="mt-1 text-xs text-gray-400">
                        {{ $activity['date']->diffForHumans() }}
                    </p>

                </div>

            </div>

        @empty

            <div class="py-8 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
                    🔔
                </div>

                <p class="mt-3 text-sm font-medium text-gray-900">
                    Aucune activité récente
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Les interactions avec vos publications apparaîtront ici.
                </p>

            </div>

        @endforelse

    </div>

</section>