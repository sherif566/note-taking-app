<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Services\NoteService;
use Illuminate\Http\Request;
use App\Models\Category;

class NoteController extends Controller
{
    protected $noteService;

    // Constructor to inject NoteService
    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    // Get all notes with categories

    public function index(Category $category)
    {
        return response()->json($category->notes, 200);
    }

    // Get a note by ID
    public function show($id)
    {
        $note = $this->noteService->findNoteById($id);
        return response()->json($note);
    }

    // Create a new note
    public function store(StoreNoteRequest $request, Category $category)
    {
        $note = $category->notes()->create($request->validated());
        return response()->json($note, 201);
    }

    // Update a note
    public function update(UpdateNoteRequest $request, $id)
    {
        return $this->noteService->updateNote($id, $request->validated());
    }

    // Delete a note
    public function destroy($id)
    {
        $note = $this->noteService->findNoteById($id);

        $this->noteService->deleteNote($note);
        return response()->json(null, 204);
    }
}
