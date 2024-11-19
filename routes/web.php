<?php

use App\Http\Controllers\SpeciesByCategoryController;
use App\Http\Controllers\SpeciesByClassController;
use Illuminate\Support\Facades\Route;

Route::get('/species/{regionId}/category/{categoryId}', [SpeciesByCategoryController::class, 'index']);
Route::get('/species/{regionId}/class/{classId}', [SpeciesByClassController::class, 'index']);


require __DIR__ . '/auth.php';
