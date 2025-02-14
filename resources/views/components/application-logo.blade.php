@props(['size' => 'md'])

@php
    $sizes = [
        'sm' => ['fontSize' => 'text-xl'],
        'md' => ['fontSize' => 'text-2xl'],
        'lg' => ['fontSize' => 'text-3xl'],
    ];

    $config = $sizes[$size] ?? $sizes['md'];
@endphp

<div>
    <h1 class="{{ $config['fontSize'] }} font-bold text-green-600 dark:text-green-400">
        Gestão<span class="text-green-400 dark:text-green-300">Pro</span>
    </h1>
</div>