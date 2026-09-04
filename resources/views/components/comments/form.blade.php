@props(['post'])

@auth

<div class="border-b border-gray-100 px-6 py-5">

    <form
        id="comment-form"
        method="POST"
        action="{{ route('comments.store', $post) }}"
    >
        @csrf

        <div class="flex gap-3">

            {{-- Avatar --}}
            <div class="h-9 w-9 shrink-0 overflow-hidden rounded-full">

                @if (auth()->user()->avatar)

                    <x-cloudinary::image
                        public-id="{{ $post->user->avatar }}"
                        alt="Photo de {{ $post->user->name }}"
                        class="h-full w-full object-cover"
                    />

                @else

                    <div class="flex h-full w-full items-center justify-center bg-gray-900 text-xs font-semibold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                @endif

            </div>


            <div class="min-w-0 flex-1">

                <textarea
                    id="comment-content"
                    name="content"
                    rows="3"
                    maxlength="1000"
                    placeholder="Écrivez un commentaire..."
                    class="block w-full resize-none rounded-xl border-gray-300 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900"
                ></textarea>


                <div
                    id="comment-error"
                    class="mt-2 hidden rounded-lg bg-red-50 px-3 py-2 text-sm text-red-600"
                ></div>


                <div class="mt-3 flex items-center justify-between">

                    <span class="text-xs text-gray-400">
                        1000 caractères maximum
                    </span>


                    <button
                        type="submit"
                        id="comment-submit"
                        class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <span id="comment-submit-text">
                            Commenter
                        </span>
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@else

<div class="border-b border-gray-100 px-6 py-5">

    <div class="rounded-xl bg-gray-50 p-5 text-center">

        <div
            class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-gray-200"
        >
            💬
        </div>

        <p class="mt-3 text-sm font-medium text-gray-900">
            Participez à la discussion
        </p>

        <p class="mt-1 text-sm text-gray-500">
            Connectez-vous pour laisser un commentaire.
        </p>

        <a
            href="{{ route('login') }}"
            class="mt-4 inline-flex rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white"
        >
            Se connecter
        </a>

    </div>

</div>

@endauth