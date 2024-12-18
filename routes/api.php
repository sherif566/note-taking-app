<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CategoryController;

/*
|---------------------------------------------------------------------------
| API Routes
|---------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Resource route for categories
Route::resource('categories', CategoryController::class);

// Resource route for notes
Route::resource('notes', NoteController::class);

// Nested routes for notes within categories
Route::prefix('categories')->group(function () {
    // Get all notes for a specific category
    Route::get('{category}/notes', [NoteController::class, 'getCategoryNotes']);

    // Create a note under a specific category
    Route::post('{category}/notes', [NoteController::class, 'storeInCategory']);

    // Update a note in a specific category
    Route::put('{category}/notes/{note}', [NoteController::class, 'updateInCategory']);

    // Delete a note from a specific category
    Route::delete('{category}/notes/{note}', [NoteController::class, 'destroyFromCategory']);
});
