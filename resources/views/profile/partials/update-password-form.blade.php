<section class="p-6 bg-blue-900 sm:rounded-lg border border-blue-700">
    <header>
        <!-- Strong readable header -->
        <h2 class="text-lg font-semibold text-white">
            {{ __('Update Password') }}
        </h2>

        <!-- Subtext with clear readability -->
        <p class="mt-1 text-sm text-white">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-white font-semibold" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full border border-white rounded-md bg-blue-800 text-white px-3 py-2 focus:border-blue-400 focus:ring-blue-400"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-400" />
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-white font-semibold" />
            <x-text-input id="update_password_password" name="password" type="password"
                class="mt-1 block w-full border border-white rounded-md bg-blue-800 text-white px-3 py-2 focus:border-blue-400 focus:ring-blue-400"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-white font-semibold" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full border border-white rounded-md bg-blue-800 text-white px-3 py-2 focus:border-blue-400 focus:ring-blue-400"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-6 py-2 bg-white hover:bg-gray-200 text-blue-900 font-semibold rounded-md shadow-md border border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-white">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
