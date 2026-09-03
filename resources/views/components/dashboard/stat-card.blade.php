@props([
    'label',
    'value',
    'icon',
])

<div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-lg">
        {{ $icon }}
    </div>

    <p class="mt-4 text-2xl font-bold text-gray-900">
        {{ $value }}
    </p>

    <p class="mt-1 text-sm text-gray-500">
        {{ $label }}
    </p>

</div>