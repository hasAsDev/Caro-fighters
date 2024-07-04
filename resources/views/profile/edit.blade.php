<x-layouts.auth>
    <div class="mt-12">
        <div class="max-w-[640px] mx-auto tablet:px-6 space-y-6">
            <div class="flex flex-col items-center py-10">
                <div class="grid grid-cols-1 space-y-4">
                    @if($top == 1)
                    <div class="min-w-96 bg-brown rounded-primative border-8 border-gray text-center font-norse py-4">
                        <h1 class="text-green text-h1 font-h1">{{"Top " . $top}}</h1>
                        <h1 class="text-red-blood text-h1 font-h1">{{$user->name}}</h1>
                        <h1 class="text-orange text-h2 font-h2">{{"Elo: " . $user->elo}}</h1>
                    </div>
                    @else
                    <div class="min-w-96 bg-brown rounded-primative border-8 border-gray text-center font-norse py-4">
                        <h1 class="text-gray text-h2 font-h2">{{"Top " . $top}}</h1>
                        <h1 class="text-gray text-h2 font-h2">{{$user->name}}</h1>
                        <h1 class="text-orange text-h3 font-h3">{{"Elo: " . $user->elo}}</h1>
                    </div>
                    @endif
                </div>
            </div>
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