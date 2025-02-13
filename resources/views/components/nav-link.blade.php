@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-600 dark:text-gray-300 text-green-600 dark:text-green-400 transition duration-150 ease-in-out border-green-500 dark:border-green-400'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 hover:border-green-500 dark:hover:border-green-400 focus:text-green-600 dark:focus:text-green-400 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
