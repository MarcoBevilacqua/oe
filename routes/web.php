<?php

use App\Http\Controllers\SpeciesController;
use Illuminate\Support\Facades\Route;

Route::get('/species/{regionId}', [SpeciesController::class, 'index'])->name('regions.index');

require __DIR__ . '/auth.php';
