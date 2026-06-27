@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-earth-300 focus:border-earth-500 focus:ring-earth-500 bg-earth-100/50 rounded-xl shadow-sm px-4 py-3 text-earth-900 placeholder-earth-500 transition-colors duration-300']) }}>
