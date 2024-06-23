<section>
    <header>
        <h1 class="text-h3 font-h3 text-brown-active">
            {{ __('Update Password') }}
        </h1>

        <p class="text-txt font-txt text-brown">
            {{ __('Ensure that the password is strong as you.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="space-y-2">
            <x-input-label for="update_password_current_password">
                Current password:
            </x-input-label>
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password">
                New password:
            </x-input-label>
            <x-text-input id="update_password_password" name="password" type="password" class=" block w-full"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password_confirmation">
                Confirm password:
            </x-input-label>
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-txt font-txt text-brown-active">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>