<x-layouts.auth>
    <div class="mt-12 rounded-primative bg-light">
        <h1 class="p-6 text-h1 font-h1 text-brown-active font-norse text-center">
            Hi, {{Auth::user()->name}}, Welcome to the caro world!
        </h1>

        {{-- Xem van dau --}}
    </div>
    <div class="mt-12 grid grid-cols-1 tablet:grid-cols-3 gap-20 px-8">
        <div class="h-[200px] bg-gray rounded-primative py-2 tablet:px-6 space-y-6">
            <form method="POST" action={{Route('searchbattleground')}} class="space-y-6">
                @csrf

                <div class="space-y-2 text-center">
                    <x-input-label for="battleground_id">
                        Battleground ID:
                    </x-input-label>
                    <x-text-input id="battleground_id" name="battleground_id" type="text" class="block w-full"
                        required />
                    <x-input-error :messages="$errors->get('battleground_id')" />
                </div>

                <div class="flex items-center justify-center gap-4">
                    <x-primary-button>{{ __('Watch') }}</x-primary-button>
                </div>
            </form>
        </div>
        <a href={{Route('ranking')}}
            class="h-[200px] bg-gray rounded-primative group flex items-center justify-center hover:bg-dark transition ease-in-out">
            <h1 class="text-h2 font-h2 text-brown font-norse group-hover:text-red-blood transition ease-in-out">
                Top 10
            </h1>
        </a>
        <a href={{Route('profile.edit')}}
            class="h-[200px] bg-gray rounded-primative group flex items-center justify-center">
            <h1 class="text-h2 font-h2 text-brown font-norse group-hover:text-brown-active transition ease-in-out">
                Profile
            </h1>
        </a>
    </div>
</x-layouts.auth>