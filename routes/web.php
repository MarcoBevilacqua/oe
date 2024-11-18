<?php

use App\Http\Controllers\RegionController;
use App\Http\Controllers\SpeciesController;
use Illuminate\Support\Facades\Route;


Route::get('/regions', [RegionController::class, 'index'])->name('regions.index');
Route::get('/regions/{regionId}', [RegionController::class, 'show'])->name('regions.show');

Route::get('/region/{regionId}/species', [SpeciesController::class, 'index'])->name('regions.edit');

require __DIR__ . '/auth.php';
