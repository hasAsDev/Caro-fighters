<section class="space-y-6">
    <header>
        <h2 class="text-h3 font-h3 text-red">
            {{ __('Delete Account') }}
        </h2>

        <p class="text-txt font-txt text-brown">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before
            deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Delete Account') }}
    </x-primary-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-2 px-8 space-y-6 bg-dark">
            @csrf
            @method('delete')

            <h2 class="text-h3 font-h3 text-red">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="text-txt font-txt text-gray">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please
                enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="space-y-2">
                <x-input-label for="password">
                    Password:
                </x-input-label>

                <x-text-input id="password" name="password" type="password" class="block w-full"
                    placeholder="{{ __('Password') }}" />

                <x-input-error class="text-txt font-txt text-red" :messages="$errors->userDeletion->get('password')" />
            </div>

            <div class="flex justify-end space-x-6">
                <x-primary-button x-on:click="$dispatch('close')" type='button' class="bg-light w-full">
                    {{ __('Cancel') }}
                </x-primary-button>

                <x-primary-button>
                    {{ __('Delete Account') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</section>