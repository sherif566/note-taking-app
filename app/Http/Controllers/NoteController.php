<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NoteRequest;
use App\Http\Requests\NoteSearchRequest;
use App\Services\NoteService;
use App\DTOs\NoteDTO;
use App\DTOs\NoteSearchDTO;
use App\Http\Resources\NoteResource;
use App\Traits\RespondsWithHttpStatus;
use App\Models\Note;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct(private NoteService $noteService) {}

    public function index(NoteSearchRequest $request)
    {
        Log::info('Note search started.', ['request' => $request->validated()]);

        $dto = NoteSearchDTO::from($request->validated());

        $notes = $this->noteService->search($dto);

        Log::info('Notes search completed.', [
            'request' => $request->validated(),
            'notes_count' => $notes->count()
        ]);

        return $this->success(
            NoteResource::collection($notes),
            'Notes retrieved successfully'
        );
    }

    public function show(Note $note)
    {
        Log::info('Displaying note', ['note_id' => $note->id]);
        return $this->success(new NoteResource($note), 'Note details retrieved successfully');
    }

    public function store(NoteRequest $request)
    {
        Log::info('New note storing started.', ['request' => $request->validated()]);

        $dto = NoteDTO::from($request->validated());
        $note = $this->noteService->create($dto);

        Log::info('New note created successfully', ['note_id' => $note->id]);

        return $this->success(new NoteResource($note), 'Note created successfully', 201);
    }

    public function update(NoteRequest $request, Note $note)
    {
        Log::info('Note updating started.', ['request' => $request->validated()]);

        $dto = NoteDTO::from($request->validated());

        $updatedNote = $this->noteService->update($note, $dto);

        Log::info('Note updated successfully', ['note_id' => $updatedNote->id]);

        return $this->success(new NoteResource($updatedNote), 'Note updated successfully');
    }

    public function destroy(Note $note)
    {
        Log::info('Note deletion started.', ['note_id' => $note->id]);

        $this->noteService->delete($note);

        Log::info('Note deletion completed.', ['note_id' => $note->id]);

        return $this->success(null, 'Note deleted successfully', 200);
    }
}
