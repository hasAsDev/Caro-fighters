<button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-txt font-txt text-brown bg-dark py-2 px-4
    rounded-primative hover:text-brown-active hover:bg-red transition ease-in-out'])
    }}>
    {{ $slot }}
</button>