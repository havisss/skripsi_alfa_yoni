<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-earth-900 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 sm:p-10 bg-earth-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-2xl border border-earth-200/50">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-earth-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-2xl border border-earth-200/50">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-earth-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-2xl border border-earth-200/50">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
