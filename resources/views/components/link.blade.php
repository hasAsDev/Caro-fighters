@props([
"active" => false,
])

<?php
    $classes = $active? 
    "text-brown-active text-h3 font-h3 border-t-2 border-brown-active px-4": 
    "text-brown text-h3 font-h3 border-t-2 border-transparent px-4 hover:text-brown-active hover:border-brown transition ease-in-out"
?>

<a {{$attributes->merge(['class' => $classes])}}>
    {{$slot}}
</a>