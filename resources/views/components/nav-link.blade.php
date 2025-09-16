@props(['active'])

@php
$classes = ($active ?? false)
? 'inline-flex items-center px-4 border border-yellow-400 rounded-full border-indigo-400 text-md font-semibold leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
: 'inline-flex items-center px-4 border rounded-full border-transparent text-md font-semibold leading-5 text-gray-900 hover:border-yellow-400 focus:outline-none focus:text-gray-700 focus:border-yellow-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>