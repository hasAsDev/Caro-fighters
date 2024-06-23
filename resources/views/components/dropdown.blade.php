<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 min-w-48 rounded-primative ltr:origin-top-right rtl:origin-top-left end-0"
        @click="open = false">
        <div class="rounded-primative bg-light py-2 px-4 space-y-4 text-center">
            {{ $content }}
        </div>
    </div>
</div>