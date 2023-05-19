@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-purple-700 text-white px-3 py-2 rounded-md text-sm font-medium'
            : 'text-white hover:bg-purple-500 hover:bg-opacity-75 px-3 py-2 rounded-md text-sm font-medium';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
