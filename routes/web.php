<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('grupos', 'grupos')
    ->middleware(['auth'])
    ->name('grupos');

Route::view('bandeiras', 'bandeiras')
    ->middleware(['auth'])
    ->name('bandeiras');

Route::view('unidades', 'unidades')
    ->middleware(['auth'])
    ->name('unidades');

Route::view('colaboradores', 'colaboradores')
    ->middleware(['auth'])
    ->name('colaboradores');

require __DIR__.'/auth.php';
