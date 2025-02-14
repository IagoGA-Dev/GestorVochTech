<?php

use App\Http\Controllers\BandeiraController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\UnidadeController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('grupos', [GrupoController::class, 'index'])->middleware(['auth'])->name('grupos');
Route::get('bandeiras', [BandeiraController::class, 'index'])->middleware(['auth'])->name('bandeiras');
Route::get('unidades', [UnidadeController::class, 'index'])->middleware(['auth'])->name('unidades');
Route::get('colaboradores', [ColaboradorController::class, 'index'])->middleware(['auth'])->name('colaboradores');


require __DIR__.'/auth.php';
