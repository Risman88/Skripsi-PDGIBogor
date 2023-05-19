@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-purple-700 text-white block px-3 py-2 rounded-md text-base font-medium'
            : 'text-white hover:bg-purple-500 hover:bg-opacity-75 block px-3 py-2 rounded-md text-base font-medium';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
