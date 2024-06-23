@props(['messages'])

@if ($messages)
<ul {{ $attributes->merge(['class' => 'text-txt font-txt text-dark']) }}>
    @foreach ((array) $messages as $message)
    <li>{{ $message }}</li>
    @endforeach
</ul>
@endif