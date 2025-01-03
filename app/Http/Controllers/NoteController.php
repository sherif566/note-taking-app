<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Services\NoteService;
use App\DTOs\NoteDTO;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\Category;

class NoteController extends Controller
{
    public function __construct(private NoteService $noteService)
    {
    }

    public function index()
    {
        $notes = $this->noteService->getAll();
        return NoteResource::collection($notes);
    }

    public function show(Note $note)
    {
        return new NoteResource($note);
    }

    public function store(NoteRequest $request)
    {
        $dto = new NoteDTO(
            title: $request->get('title'),
            description: $request->get('description'),
            category_id: $request->get('category_id')
        );

        $note = $this->noteService->create($dto);

        Log::info("Note created successfully", ['note' => $note]);
        return new NoteResource($note);
    }

    public function update(NoteRequest $request, Note $note)
    {
        $dto = new NoteDTO(
            title: $request->get('title'),
            description: $request->get('description'),
            category_id: $request->get('category_id')
        );

        $updatedNote = $this->noteService->update($note, $dto);

        Log::info("Note updated successfully", ['note' => $updatedNote]);
        return new NoteResource($updatedNote);
    }

    public function destroy(Note $note)
    {
        Log::info("Deleting note", ['note_id' => $note->id]);
        $this->noteService->delete($note);
        Log::info("Note deleted successfully", ['note_id' => $note->id]);
        return response()->json(['message' => 'Note deleted successfully'], Response::HTTP_OK);
    }

}
