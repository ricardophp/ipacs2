<?php

use App\Http\Livewire\GrillaEstudios;
use App\Http\Livewire\ShowEstudios;

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\PdfInforme;
use App\Http\Livewire\UsersTable;

Route::get('/', function () {
    return view('principal');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/dashboard',ShowEstudios::class)->name('dashboard');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/estudios',GrillaEstudios::class)->name('estudios');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/users',UsersTable::class)
  ->name('users');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/pdf',PdfInforme::class)->name('pdf');

