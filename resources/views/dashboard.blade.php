<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-earth-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-earth-100/90 backdrop-blur-md overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-2xl border border-earth-200/50">
                <div class="p-8 text-earth-800 text-lg">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
