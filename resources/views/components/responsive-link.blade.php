@props(['active' => false])

@php
$classes = $active ?
'block text-center text-brown-active text-txt font-txt border-t-2 border-brown-active py-2 transition
duration-150 ease-in-out'
: 'block text-center text-brown text-txt font-txt border-t-2 border-brown py-2 transition
duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>