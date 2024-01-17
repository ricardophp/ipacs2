<?php

use App\Http\Livewire\GrillaEstudios;
use App\Http\Livewire\ShowEstudios;

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\PdfInforme;
use App\Http\Livewire\TablaEstudios;
use App\Http\Livewire\UsersTable;
use App\Http\Livewire\UserEdit;

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
])->get('/estudios2',TablaEstudios::class)->name('estudios2');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/users',UsersTable::class)
  ->name('users.index');

  Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/users/crear',UserEdit::class)
  ->name('users.crear');

  Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/users/editar',UserEdit::class)
  ->name('users.editar');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->get('/pdf',PdfInforme::class)->name('pdf');

