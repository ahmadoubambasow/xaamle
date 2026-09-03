@props(['posts'])

@if ($posts->isNotEmpty())

    <section>

        <div class="mb-5">

            <h2 class="text-lg font-semibold tracking-tight text-gray-900">
                🔥 À découvrir
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Découvrez les publications qui intéressent la communauté.
            </p>

        </div>

        <div class="grid gap-5 md:grid-cols-3">

            @foreach ($posts as $post)

                <x-dashboard.discover-post-card :post="$post" />

            @endforeach

        </div>

    </section>

@endif