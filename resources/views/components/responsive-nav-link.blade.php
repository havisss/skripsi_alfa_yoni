@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-earth-600 text-start text-base font-medium text-earth-800 bg-earth-200 focus:outline-none focus:text-earth-900 focus:bg-earth-300 focus:border-earth-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-earth-600 hover:text-earth-800 hover:bg-earth-100 hover:border-earth-400 focus:outline-none focus:text-earth-800 focus:bg-earth-100 focus:border-earth-400 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
