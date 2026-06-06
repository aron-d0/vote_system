<section class="p-6 bg-blue-900 sm:rounded-lg border border-blue-700">
    <header>
        <!-- Strong readable header -->
        <h2 class="text-lg font-semibold text-white">
            {{ __('Profile Information') }}
        </h2>

        <!-- Subtext with clear readability -->
        <p class="mt-1 text-sm text-white">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Name Field -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-white font-semibold" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full border border-white rounded-md bg-blue-800 text-white px-3 py-2 focus:border-blue-400 focus:ring-blue-400"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('name')" />
        </div>

        <!-- Email Field -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white font-semibold" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full border border-white rounded-md bg-blue-800 text-white px-3 py-2 focus:border-blue-400 focus:ring-blue-400"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-white">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-blue-300 hover:text-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 rounded-md">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-white">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
