<x-layouts.auth>
    <div class="mt-12 rounded-primative bg-light">
        <h1 class="p-6 text-h1 font-h1 text-brown-active font-norse text-center">
            Hi, {{Auth::user()->name}}, Welcome to the caro world!
        </h1>
    </div>
</x-layouts.auth>