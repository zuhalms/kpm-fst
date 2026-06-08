<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-[#121212] transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-[#1e1e1e] shadow dark:shadow-lg sm:rounded-lg border border-gray-100 dark:border-gray-800 transition-colors duration-300">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-[#1e1e1e] shadow dark:shadow-lg sm:rounded-lg border border-gray-100 dark:border-gray-800 transition-colors duration-300">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-[#1e1e1e] shadow dark:shadow-lg sm:rounded-lg border border-gray-100 dark:border-gray-800 transition-colors duration-300">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
