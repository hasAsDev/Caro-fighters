@props(['status'])

@if ($status)
<div {{ $attributes->merge(['class' => 'text-txt font-txt text-brown-active']) }}>
    {{ $status }}
</div>
@endif