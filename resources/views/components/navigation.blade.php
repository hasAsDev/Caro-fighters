<nav x-data="{ open: false }" class="border-b-2 border-brown bg-dark py-2">
    <!-- Primary Navigation Menu -->
    <div class="max-w-[1280px] mx-auto px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('welcome') }}">
                    <x-logo class="block size-9" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden tablet:flex tablet:grow tablet:justify-center tablet:shrink items-center space-x-2">
                <x-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-link>
                <x-link :href="route('battle')" :active="request()->routeIs('battle')">
                    {{ __('Battle') }}
                </x-link>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden tablet:flex tablet:items-center">
                <x-dropdown>
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-h2 font-h2 text-brown font-norse hover:text-brown-active focus:text-brown-active transition ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="">
                                <svg class="fill-current size-10" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                class="hover:text-red hover:border-red">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center tablet:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-primative text-brown-active border-2 border-brown transition ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="bg-dark tablet:hidden">
        <!-- Authentication -->
        <div class="border-t-2 border-brown">
            <div class="text-center">
                <div class="text-h2 font-h2 text-brown-active font-norse">{{ Auth::user()->name }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-link :href="route('logout')" onclick="event.preventDefault();
                                    this.closest('form').submit();" class="text-red border-red border-y-2">
                    {{ __('Log Out') }}
                </x-responsive-link>
            </form>
        </div>

        <h1 class="text-txt font-txt text-brown font-norse text-center my-6 animate-pulse">
            XOXOXOXOXOXOXOXOXOXOXOXOXOXOXOXOXOXOXOXOXOXOXOXOXOXO
        </h1>
        <!-- Responsive Settings Options -->
        <div>
            <div>
                <x-responsive-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-link>
                <x-responsive-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-link>
                <x-responsive-link :href="route('battle')" :active="request()->routeIs('battle')">
                    {{ __('Battle') }}
                </x-responsive-link>
            </div>
        </div>
    </div>
</nav>