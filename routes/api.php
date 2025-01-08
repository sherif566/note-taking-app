<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryNoteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::apiResource('categories', CategoryController::class);

Route::apiResource('notes', NoteController::class);

Route::prefix('categories')->group(function () {
    Route::apiResource('{category}/notes', CategoryNoteController::class);
});
