@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-earth-600 text-sm font-semibold leading-5 text-earth-900 focus:outline-none focus:border-earth-700 transition duration-300 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-earth-600 hover:text-earth-800 hover:border-earth-400 focus:outline-none focus:text-earth-800 focus:border-earth-400 transition duration-300 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
