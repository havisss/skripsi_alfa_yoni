<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-earth-800 border border-transparent rounded-full font-semibold text-xs text-earth-100 uppercase tracking-widest hover:bg-earth-900 focus:bg-earth-900 active:bg-earth-900 focus:outline-none focus:ring-2 focus:ring-earth-500 focus:ring-offset-2 focus:ring-offset-earth-100 transition ease-in-out duration-300 shadow-sm']) }}>
    {{ $slot }}
</button>
