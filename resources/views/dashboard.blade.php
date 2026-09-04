<x-app-layout>

    {{-- =========================================================
         HEADER
    ========================================================== --}}

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



    {{-- =========================================================
         CONTENU
    ========================================================== --}}

    <div class="min-h-screen bg-gray-50 py-8 sm:py-10">

        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">


            {{-- =====================================================
                 BIENVENUE
            ====================================================== --}}

            <x-dashboard.welcome
                :user="$user"
            />



            {{-- =====================================================
                 STATISTIQUES
            ====================================================== --}}

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



            {{-- =====================================================
                 ACTIONS + ACTIVITÉ
            ====================================================== --}}

            <section class="grid gap-6 lg:grid-cols-3">

                {{-- Actions rapides --}}
                <div>

                    <x-dashboard.quick-actions />

                </div>


                {{-- Activité récente --}}
                <div class="lg:col-span-2">

                    <x-dashboard.recent-activity
                        :activities="$activities"
                    />

                </div>

            </section>



            {{-- =====================================================
                 MES PUBLICATIONS + COMPTES SUIVIS
            ====================================================== --}}

            <section class="grid gap-6 lg:grid-cols-3">

                {{-- Mes publications --}}
                <div class="lg:col-span-2">

                    <x-dashboard.latest-posts
                        :posts="$latestPosts"
                    />

                </div>


                {{-- Comptes suivis --}}
                <div>

                    <x-dashboard.following
                        :following="$following"
                    />

                </div>

            </section>



            {{-- =====================================================
                 DÉCOUVRIR
            ====================================================== --}}

            <x-dashboard.discover
                :posts="$discoverPosts"
            />



            {{-- =====================================================
                 CTA
            ====================================================== --}}

            <x-dashboard.cta />

        </div>

    </div>

</x-app-layout>