<x-layouts.auth>
    <div class="py-6">
        <div class="max-w-[640px] mx-auto tablet:px-6 space-y-6">
            <div class="rounded-primative p-8 bg-light">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="rounded-primative p-8 bg-light">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-primative p-8 bg-light">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-layouts.auth>