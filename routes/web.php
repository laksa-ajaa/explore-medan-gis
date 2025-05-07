<?php

use App\Http\Controllers\PetaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

Route::get('/', [WebController::class, 'index'])->name('home');

Route::get('/peta', [PetaController::class, 'index'])->name('peta');
Route::get('/peta/jalur/{start_id}/{wisata_id}', [PetaController::class, 'getJalurByStartAndWisata'])->name('peta.jalur');
