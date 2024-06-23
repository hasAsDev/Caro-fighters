<x-layouts.auth>
    <script>
        window.addEventListener("alpine:init", () => {
            window.Echo.private(
                'channel_for_fighter_'
                + <?php echo Auth::user()->id ?>
            ).listen('BattleStarted', (e) => {
                $battleground_id = e.battleground.battleground_id;
                window.location.href = '/battleground/' + $battleground_id;
            })
        })
    </script>
    <div class="mt-12 py-6 rounded-primative bg-light text-center">
        <h1 class="text-h1 font-h1 text-brown-active font-norse">
            Fighter, {{Auth::user()->name}}, Go to battle!
        </h1>
        <form action="/battle" method="POST">
            @csrf
            @method("PUT")
            <x-primary-button>Go to battle XO</x-primary-button>
            <h1 class='inline-block pl-2'>Finding</h1>
        </form>
    </div>
    <div class="mt-4 px-6 py-6 rounded-primative bg-light">
        <h1 class="text-h1 font-h1 text-brown-active font-norse text-center">
            ALl the battlegrounds
        </h1>
        <div class="mt-6 grid grid-cols-2 tablet:grid-cols-3 gap-4">
            @foreach ($battlegrounds as $battleground)
            <a href="/battleground/{{$battleground->battleground_id}}"
                class="group w-full text-center py-2 space-y-2 rounded-primative border-4 border-double border-red hover:bg-red transition ease-in-out">
                <h1
                    class="text-txt font-txt tablet:text-h3 tablet:font-h3 text-brown font-norse group-hover:text-brown-active transition ease-in-out">
                    {{ App\Models\User::find((
                    Auth::id() == $battleground['fighter_X'] ?
                    $battleground['fighter_O']:
                    $battleground['fighter_X']
                    ))->name }}
                </h1>
                <h1 class="text-txt font-txt font-norse text-gray">
                    {{$battleground->battleground_id}}
                </h1>
            </a>
            @endforeach

        </div>
    </div>
</x-layouts.auth>