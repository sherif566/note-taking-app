<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('categories', CategoryController::class);

Route::resource('notes', NoteController::class);


// This will route to the getNotesByCategory method to fetch notes for a specific category
Route::get('/categories/{categoryName}/notes', [CategoryController::class, 'getNotesByCategory']);;
