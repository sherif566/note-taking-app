<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('categories', CategoryController::class);

Route::apiResource('notes', NoteController::class);

Route::prefix('categories')->group(function () {
    Route::get('{category}/notes', [NoteController::class, 'getCategoryNotes']);

    Route::post('{category}/notes', [NoteController::class, 'storeInCategory']);

    Route::put('{category}/notes/{note}', [NoteController::class, 'updateInCategory']);

    Route::delete('{category}/notes/{note}', [NoteController::class, 'destroyFromCategory']);
});
