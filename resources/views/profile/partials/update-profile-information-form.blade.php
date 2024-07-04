<section>
    <header>
        <h1 class="text-h3 font-h3 text-brown-active">
            {{ __('Change the name, change the world') }}
        </h1>

        <p class="text-txt font-txt text-brown">
            {{ __("You want to get a new name? Come on. It will be no longer free. ") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-2">
            <x-input-label for="name">
                Name:
            </x-input-label>
            <x-text-input id="name" name="name" type="text" class="block w-full" required />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-txt font-txt text-brown-active">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>