<x-layouts.auth>
    <div class="mt-12 rounded-primative bg-light">
        <div class="flex flex-col items-center py-10">
            <h1 class="text-h1 font-h1 text-green font-norse mb-12">Top 10 fighters</h1>
            <div class="grid grid-cols-1 space-y-4">
                @foreach ($fighters as $index => $fighter)
                @if($index + 1 == 1)
                <div class="min-w-96 bg-dark rounded-primative text-center font-norse py-4">
                    <h1 class="text-green text-h1 font-h1">{{"Top " . $index + 1}}</h1>
                    <h1 class="text-red-blood text-h1 font-h1">{{$fighter->name}}</h1>
                    <h1 class="text-orange text-h2 font-h2">{{"Elo: " . $fighter->elo}}</h1>
                </div>
                @else
                <div class="min-w-96 bg-dark rounded-primative text-center font-norse py-4">
                    <h1 class="text-gray text-h2 font-h2">{{"Top " . $index + 1}}</h1>
                    <h1 class="text-gray text-h2 font-h2">{{$fighter->name}}</h1>
                    <h1 class="text-orange text-h3 font-h3">{{"Elo: " . $fighter->elo}}</h1>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.auth>