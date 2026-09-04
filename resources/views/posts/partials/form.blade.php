{{-- Titre --}}
<div>
    <label
        for="title"
        class="mb-2 block text-sm font-medium text-gray-700"
    >
        Titre
    </label>

    <input
        id="title"
        name="title"
        type="text"
        value="{{ old('title', $post->title ?? '') }}"
        required
        autofocus
        maxlength="255"
        placeholder="Ex. Comment bien débuter avec Laravel ?"
        class="block w-full rounded-xl border-gray-300 px-4 py-3 text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
    >

    @error('title')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror
</div>


{{-- Résumé --}}
<div>
    <label
        for="excerpt"
        class="mb-2 block text-sm font-medium text-gray-700"
    >
        Résumé
        <span class="font-normal text-gray-400">
            (facultatif)
        </span>
    </label>

    <textarea
        id="excerpt"
        name="excerpt"
        rows="3"
        maxlength="500"
        placeholder="Présentez brièvement votre publication..."
        class="block w-full rounded-xl border-gray-300 px-4 py-3 text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
    >{{ old('excerpt', $post->excerpt ?? '') }}</textarea>

    <div class="mt-2 flex justify-between">
        <p class="text-xs text-gray-400">
            Ce résumé pourra être affiché dans le fil d'actualité.
        </p>

        <span
            id="excerpt-counter"
            class="text-xs text-gray-400"
        >
            0 / 500
        </span>
    </div>

    @error('excerpt')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror
</div>


{{-- Contenu --}}
<div>
    <label
        for="content"
        class="mb-2 block text-sm font-medium text-gray-700"
    >
        Contenu
    </label>

    <textarea
        id="content"
        name="content"
        rows="14"
        required
        placeholder="Commencez à partager votre savoir..."
        class="block w-full rounded-xl border-gray-300 px-4 py-3 text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
    >{{ old('content', $post->content ?? '') }}</textarea>

    <p class="mt-2 text-xs text-gray-400">
        Minimum 10 caractères.
    </p>

    @error('content')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror
</div>


{{-- Image de couverture --}}
<div>
    <label
        for="cover_image"
        class="mb-2 block text-sm font-medium text-gray-700"
    >
        Image de couverture
        <span class="font-normal text-gray-400">
            (facultatif)
        </span>
    </label>

    @if (isset($post) && $post->cover_image)
        <div class="mb-4 overflow-hidden rounded-xl border border-gray-200">
            <x-cloudinary::image
                public-id="{{ $post->cover_image }}"
                alt="{{ $post->title }}"
                class="h-full w-full object-cover"
            />
        </div>
    @endif

    <label
        for="cover_image"
        class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 px-6 py-10 text-center transition hover:border-gray-400 hover:bg-gray-50"
    >
        <div class="mb-3 text-3xl">
            🖼️
        </div>

        <p class="text-sm font-medium text-gray-700">
            Cliquez pour choisir une image
        </p>

        <p class="mt-1 text-xs text-gray-400">
            JPG, JPEG, PNG — maximum 2 Mo
        </p>

        <input
            id="cover_image"
            name="cover_image"
            type="file"
            accept="image/*"
            class="hidden"
        >
    </label>

    <div
        id="image-preview-container"
        class="mt-4 hidden overflow-hidden rounded-xl border border-gray-200"
    >
        <img
            id="image-preview"
            src=""
            alt="Aperçu de la couverture"
            class="max-h-72 w-full object-cover"
        >
    </div>

    @error('cover_image')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror
</div>


{{-- Statut --}}
<div>
    <label class="mb-3 block text-sm font-medium text-gray-700">
        Statut
    </label>

    <div class="space-y-3">

        {{-- Brouillon --}}
        <label class="flex cursor-pointer items-start gap-4 rounded-xl border border-gray-200 p-4 transition hover:bg-gray-50">

            <input
                type="radio"
                name="status"
                value="draft"
                {{ old('status', $post->status ?? 'draft') === 'draft' ? 'checked' : '' }}
                class="mt-1 h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900"
            >

            <div>
                <p class="font-medium text-gray-900">
                    Enregistrer comme brouillon
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Votre publication restera privée.
                </p>
            </div>

        </label>


        {{-- Publié --}}
        <label class="flex cursor-pointer items-start gap-4 rounded-xl border border-gray-200 p-4 transition hover:bg-gray-50">

            <input
                type="radio"
                name="status"
                value="published"
                {{ old('status', $post->status ?? '') === 'published' ? 'checked' : '' }}
                class="mt-1 h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900"
            >

            <div>
                <p class="font-medium text-gray-900">
                    Publier
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Votre publication sera visible par la communauté.
                </p>
            </div>

        </label>

    </div>

    @error('status')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const excerpt = document.getElementById('excerpt');
        const counter = document.getElementById('excerpt-counter');

        if (excerpt && counter) {

            function updateCounter() {
                counter.textContent = `${excerpt.value.length} / 500`;
            }

            excerpt.addEventListener('input', updateCounter);

            updateCounter();
        }


        const imageInput = document.getElementById('cover_image');
        const previewContainer = document.getElementById('image-preview-container');
        const preview = document.getElementById('image-preview');

        if (imageInput && previewContainer && preview) {

            imageInput.addEventListener('change', function () {

                const file = this.files[0];

                if (!file) {
                    previewContainer.classList.add('hidden');
                    preview.src = '';
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (event) {
                    preview.src = event.target.result;
                    previewContainer.classList.remove('hidden');
                };

                reader.readAsDataURL(file);
            });
        }

    });
</script>