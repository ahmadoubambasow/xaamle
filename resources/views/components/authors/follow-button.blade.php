@props(['author'])

@php
    $isFollowing = auth()->check()
        && auth()->user()->isFollowing($author);

    $followersCount = $author->followers()->count();
@endphp

<div
    data-follow-component
    data-follow-url="{{ route('authors.follow.toggle', $author) }}"
    class="inline-flex flex-col items-start gap-1"
>
    @auth
        @if(auth()->id() !== $author->id)

            <button
                type="button"
                data-action="toggle-follow"
                data-following="{{ $isFollowing ? 'true' : 'false' }}"
                aria-pressed="{{ $isFollowing ? 'true' : 'false' }}"
                class="inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold transition
                    {{ $isFollowing
                        ? 'border border-gray-200 bg-white text-gray-700 hover:border-red-200 hover:bg-red-50 hover:text-red-600'
                        : 'bg-gray-900 text-white hover:bg-gray-800'
                    }}"
            >
                <svg
                    data-follow-icon
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4v16m8-8H4"
                    />
                </svg>

                <span data-follow-label>
                    {{ $isFollowing ? 'Suivi' : 'Suivre' }}
                </span>
            </button>

            <span class="text-xs text-gray-500">
                <span data-followers-count>{{ $followersCount }}</span>
                <span data-followers-label>
                    {{ $followersCount > 1 ? 'abonnés' : 'abonné' }}
                </span>
            </span>

            <span
                data-follow-error
                class="hidden text-xs text-red-500"
            ></span>

        @else

            <span class="text-xs text-gray-400">
                C'est vous
            </span>

        @endif
    @else

        <a
            href="{{ route('login') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800"
        >
            <svg
                class="h-4 w-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 4v16m8-8H4"
                />
            </svg>

            <span>Suivre</span>
        </a>

        <span class="text-xs text-gray-500">
            <span data-followers-count>{{ $followersCount }}</span>
            <span data-followers-label>
                {{ $followersCount > 1 ? 'abonnés' : 'abonné' }}
            </span>
        </span>

    @endauth
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    document.addEventListener('click', async (event) => {

        const button = event.target.closest(
            '[data-action="toggle-follow"]'
        );

        if (!button) {
            return;
        }

        const component = button.closest(
            '[data-follow-component]'
        );

        if (!component) {
            return;
        }

        const url = component.dataset.followUrl;

        if (!url) {
            return;
        }

        const label = button.querySelector(
            '[data-follow-label]'
        );

        const icon = button.querySelector(
            '[data-follow-icon]'
        );

        const countElement = component.querySelector(
            '[data-followers-count]'
        );

        const followersLabel = component.querySelector(
            '[data-followers-label]'
        );

        const errorElement = component.querySelector(
            '[data-follow-error]'
        );

        const wasFollowing =
            button.dataset.following === 'true';

        // Éviter les doubles clics
        if (button.disabled) {
            return;
        }

        button.disabled = true;

        errorElement?.classList.add('hidden');

        // Petit état de chargement
        if (label) {
            label.textContent = '...';
        }

        try {

            const response = await fetch(url, {
                method: 'POST',

                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content'),

                    'Accept': 'application/json',

                    'Content-Type': 'application/json',
                },

                credentials: 'same-origin',
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data.message ||
                    'Une erreur est survenue.'
                );
            }

            const following = data.following;
            const followersCount = data.followers_count;

            // État du bouton
            button.dataset.following =
                following ? 'true' : 'false';

            button.setAttribute(
                'aria-pressed',
                following ? 'true' : 'false'
            );

            // Texte
            if (label) {
                label.textContent =
                    following ? 'Suivi' : 'Suivre';
            }

            // Icône
            if (icon) {

                if (following) {
                    icon.innerHTML = `
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"
                        />
                    `;
                } else {
                    icon.innerHTML = `
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 4v16m8-8H4"
                        />
                    `;
                }
            }

            // Nombre d'abonnés
            if (countElement) {
                countElement.textContent =
                    followersCount;
            }

            if (followersLabel) {
                followersLabel.textContent =
                    followersCount > 1
                        ? 'abonnés'
                        : 'abonné';
            }

            // Style du bouton
            if (following) {

                button.classList.remove(
                    'bg-gray-900',
                    'text-white',
                    'hover:bg-gray-800'
                );

                button.classList.add(
                    'border',
                    'border-gray-200',
                    'bg-white',
                    'text-gray-700',
                    'hover:border-red-200',
                    'hover:bg-red-50',
                    'hover:text-red-600'
                );

            } else {

                button.classList.remove(
                    'border',
                    'border-gray-200',
                    'bg-white',
                    'text-gray-700',
                    'hover:border-red-200',
                    'hover:bg-red-50',
                    'hover:text-red-600'
                );

                button.classList.add(
                    'bg-gray-900',
                    'text-white',
                    'hover:bg-gray-800'
                );
            }

        } catch (error) {

            console.error(
                'Erreur suivi auteur:',
                error
            );

            if (label) {
                label.textContent =
                    wasFollowing ? 'Suivi' : 'Suivre';
            }

            if (errorElement) {
                errorElement.textContent =
                    error.message ||
                    'Impossible de modifier le suivi.';

                errorElement.classList.remove('hidden');
            }

        } finally {

            button.disabled = false;
        }
    });
});
</script>