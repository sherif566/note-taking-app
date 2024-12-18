<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Category;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Services\NoteService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class NoteController extends Controller
{
    protected $noteService;

    // Constructor to inject NoteService
    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    // General Notes Management

    // Get all notes (without category context)
    public function index()
    {
        $notes = $this->noteService->getAllNotes(); // Fetch all notes
        return response()->json($notes, 200);
    }

    // Get a specific note by ID
    public function show($id)
    {
        $note = $this->noteService->findNoteById($id);
        if (!$note) {
            return response()->json(['error' => 'Note not found'], 404);
        }
        return response()->json($note, 200);
    }

    // Create a new note (no category context here)
    public function store(StoreNoteRequest $request)
    {
        $note = $this->noteService->createNote($request->validated());
        return response()->json($note, 201);
    }

    // Update a note (no category context here)
    public function update(UpdateNoteRequest $request, $id)
    {
        $note = $this->noteService->updateNote($id, $request->validated());
        return response()->json($note, 200);
    }

    // Delete a note (no category context here)
    public function destroy($id)
    {
        $note = $this->noteService->findNoteById($id);
        if (!$note) {
            return response()->json(['error' => 'Note not found'], 404);
        }

        $this->noteService->deleteNote($note);
        return response()->json(['message' => 'Note deleted successfully'], 200);
    }

    // Category-Specific Notes Management

    // Get all notes for a specific category
    public function getCategoryNotes(Category $category)
    {
        // Fetch notes for the category
        return response()->json($category->notes, 200);
    }

    // Create a new note within a specific category
    public function storeInCategory(StoreNoteRequest $request, Category $category)
    {
        $note = $this->noteService->createNoteInCategory($request->validated(), $category);
        return response()->json($note, Response::HTTP_CREATED);
    }


    // Update a note within a specific category
    public function updateInCategory(UpdateNoteRequest $request, Category $category, Note $note)
    {
        // Update the note under the specified category
        $updatedNote = $this->noteService->updateNoteInCategory($request->validated(), $category, $note);
        return response()->json($updatedNote, 200);
    }

    // Delete a note from a specific category
    public function destroyFromCategory(Category $category, Note $note)
    {
        // Delete the note under the specified category
        $this->noteService->deleteNoteFromCategory($category, $note);
        return response()->json(['message' => 'Note deleted successfully'], 200);
    }
}

