<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="text-xl font-semibold tracking-tight text-gray-900">
                Tableau de bord
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Votre activité sur Xaamlé.
            </p>
        </div>

    </x-slot>


    <div class="min-h-screen bg-gray-50 py-8 sm:py-10">

        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- Bienvenue --}}
            <x-dashboard.welcome :user="$user" />


            {{-- Statistiques --}}
            <section>

                <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

                    <x-dashboard.stat-card
                        label="Publications"
                        :value="$stats['posts']"
                        icon="📝"
                    />

                    <x-dashboard.stat-card
                        label="J'aime reçus"
                        :value="$stats['likes']"
                        icon="❤️"
                    />

                    <x-dashboard.stat-card
                        label="Commentaires reçus"
                        :value="$stats['comments']"
                        icon="💬"
                    />

                    <x-dashboard.stat-card
                        label="Abonnés"
                        :value="$stats['followers']"
                        icon="👥"
                    />

                </div>

            </section>


            {{-- Actions + activité --}}
            <section class="grid gap-6 lg:grid-cols-3">

                <x-dashboard.quick-actions />

                <div class="lg:col-span-2">

                    <x-dashboard.recent-activity
                        :activities="$activities"
                    />

                </div>

            </section>


            {{-- Mes publications --}}
            <x-dashboard.latest-posts
                :posts="$latestPosts"
            />


            {{-- Découvrir --}}
            <x-dashboard.discover
                :posts="$discoverPosts"
            />


            {{-- CTA --}}
            <x-dashboard.cta />

        </div>

    </div>

</x-app-layout>