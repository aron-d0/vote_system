<x-app-layout>
    <x-slot name="header">
        <!-- Light header text on dark background -->
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <!-- Dark background -->
    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Profile Information -->
            <div class="p-6 bg-gray-800 sm:rounded-lg border border-gray-700 text-gray-100">
                <div class="max-w-xl">
                    <h3 class="text-lg font-bold mb-4 text-white">Profile Information</h3>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-6 bg-gray-800 sm:rounded-lg border border-gray-700 text-gray-100">
                <div class="max-w-xl">
                    <h3 class="text-lg font-bold mb-4 text-white">Update Password</h3>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User -->
            <div class="p-6 bg-gray-800 sm:rounded-lg border border-gray-700 text-gray-100">
                <div class="max-w-xl">
                    <!-- Fixed: Delete Account header is now white -->
                    <h3 class="text-lg font-bold mb-4 text-white">Delete Account</h3>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
