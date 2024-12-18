<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Category;
use App\Http\Requests\NoteRequest;
use App\Services\NoteService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class NoteController extends Controller
{
    protected $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    // General Notes Management

    public function index()
    {
        $notes = $this->noteService->getAllNotes(); // Fetch all notes
        return response()->json($notes, 200);
    }

    public function show($id)
    {
        $note = $this->noteService->findNoteById($id);
        if (!$note) {
            return response()->json(['error' => 'Note not found'], 404);
        }
        return response()->json($note, 200);
    }

    public function store(NoteRequest $request)
    {
        $note = $this->noteService->createNote($request->validated());
        return response()->json($note, 201);
    }

    public function update(NoteRequest $request, $id)
    {
        $note = $this->noteService->updateNote($id, $request->validated());
        return response()->json($note, 200);
    }

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

    public function getCategoryNotes(Category $category)
    {
        return response()->json($category->notes, 200);
    }

    public function storeInCategory(NoteRequest $request, Category $category)
    {
        $note = $this->noteService->createNoteInCategory($request->validated(), $category);
        return response()->json($note, Response::HTTP_CREATED);
    }


    public function updateInCategory(NoteRequest $request, Category $category, Note $note)
    {
        $updatedNote = $this->noteService->updateNoteInCategory($request->validated(), $category, $note);
        return response()->json($updatedNote, 200);
    }

    public function destroyFromCategory(Category $category, Note $note)
    {
        $this->noteService->deleteNoteFromCategory($category, $note);
        return response()->json(['message' => 'Note deleted successfully'], 200);
    }
}

