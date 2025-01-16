<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NoteRequest;
use App\Services\NoteService;
use App\DTOs\NoteDTO;
use App\Http\Resources\NoteResource;
use App\Traits\RespondsWithHttpStatus;
use App\Models\Note;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    use RespondsWithHttpStatus;

    private NoteService $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function index(Request $request)
    {
        $notes = $this->noteService->getAll($request->input('search'));
        Log::info('Retrieving all notes', ['search' => $request->input('search')]);
        return $this->success(NoteResource::collection($notes), 'Notes retrieved successfully');
    }

    public function show(Note $note)
    {
        Log::info('Displaying note', ['note_id' => $note->id]);
        return $this->success(new NoteResource($note), 'Note details retrieved successfully');
    }

    public function store(NoteRequest $request)
    {
        $dto = new NoteDTO($request->validated());

        Log::info('Attempting to create a note', ['data' => $request->validated()]);
        $note = $this->noteService->create($dto);
        Log::info('Note created successfully', ['note_id' => $note->id]);

        return $this->success(new NoteResource($note), 'Note created successfully', 201);
    }

    public function update(NoteRequest $request, Note $note)
    {
        $dto = new NoteDTO($request->validated());

        Log::info('Attempting to update note', ['note_id' => $note->id, 'data' => $request->validated()]);
        $updatedNote = $this->noteService->update($note, $dto);
        Log::info('Note updated successfully', ['note_id' => $updatedNote->id]);

        return $this->success(new NoteResource($updatedNote), 'Note updated successfully');
    }

    public function destroy(Note $note)
    {
        Log::info('Attempting to delete note');
        $this->noteService->delete($note);
        Log::info('Note deleted successfully');

        return $this->success(null, 'Note deleted successfully', 200);
    }
}
