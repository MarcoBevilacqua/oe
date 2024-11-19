<?php

use App\Http\Controllers\SpeciesByCategoryController;
use App\Http\Controllers\SpeciesByClassController;
use Illuminate\Support\Facades\Route;

Route::get('/species/{categoryId}/category', [SpeciesByCategoryController::class, 'index']);
Route::get('/species/{classId}/class', [SpeciesByClassController::class, 'index']);

require __DIR__ . '/auth.php';
