<?php

namespace App\Http\Controllers;

use App\Services\NoteService;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    protected $noteService;

    // Constructor to inject NoteService
    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    // Get all notes with categories
    public function index()
    {
        $notes = $this->noteService->getAllNotes();
        return response()->json($notes);
    }

    // Get a note by ID
    public function show($id)
    {
        $note = $this->noteService->findNoteById($id);
        return response()->json($note);
    }

    // Create a new note
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $note = $this->noteService->createNote($data);
        return response()->json($note, 201);
    }

    // Update a note
    public function update(Request $request, $id)
    {
        $note = $this->noteService->findNoteById($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $updatedNote = $this->noteService->updateNote($note, $data);
        return response()->json($updatedNote);
    }

    // Delete a note
    public function destroy($id)
    {
        $note = $this->noteService->findNoteById($id);

        $this->noteService->deleteNote($note);
        return response()->json(null, 204);
    }
}
