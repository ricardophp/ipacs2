<?php

use App\Http\Controllers\GrillaEstudiosController;
use App\Http\Livewire\CargaInforme;
use App\Http\Livewire\EditorComponent;
use App\Http\Livewire\EstudioComponent;
use App\Http\Livewire\GrillaEstudios;
use App\Http\Livewire\ShowEstudios;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Livewire\EstudiosTable;
use App\Http\Livewire\PdfInforme;

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
])->get('/pdf',PdfInforme::class)->name('pdf');

