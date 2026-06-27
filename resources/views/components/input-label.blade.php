@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-earth-700 mb-1 ml-1']) }}>
    {{ $value ?? $slot }}
</label>
