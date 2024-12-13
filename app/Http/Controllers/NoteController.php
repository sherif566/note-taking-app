<?php

namespace App\Http\Controllers;

use App\Services\NoteService;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    protected $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function store(Request $request)
    {
        $note = $this->noteService->create($request);
        return response()->json($note, 201);
    }

    public function index()
    {
        $notes = $this->noteService->getAll();
        return response()->json($notes);
    }

    public function show($id)
    {
        $note = $this->noteService->get($id);
        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }
        return response()->json($note);
    }

    public function update(Request $request, $id)
    {
        $note = $this->noteService->update($request, $id);
        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }
        return response()->json($note);
    }

    public function destroy($id)
    {
        $result = $this->noteService->delete($id);
        if (!$result) {
            return response()->json(['message' => 'Note not found'], 404);
        }
        return response()->json(['message' => 'Note deleted successfully']);
    }
}
