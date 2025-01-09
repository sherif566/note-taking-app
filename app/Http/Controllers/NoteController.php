<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NoteRequest;
use App\Services\NoteService;
use App\DTOs\NoteDTO;
use App\Http\Resources\NoteResource;
use App\Traits\RespondsWithHttpStatus;
use App\Models\Note;

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
        return $this->success(NoteResource::collection($notes), 'Notes retrieved successfully');
    }

    public function show(Note $note)
    {
        return $this->success(new NoteResource($note), 'Note details retrieved successfully');
    }

    public function store(NoteRequest $request)
    {
        // Retrieve validated data
        $validated = $request->validated();

        // Create DTO with all necessary parameters
        $dto = new NoteDTO(
            $validated['title'],
            $validated['description'],
            $validated['category_id'] ?? null  // Use null-coalescing operator for optional parameters
        );

        // Proceed with your service layer
        $note = $this->noteService->create($dto);
        return $this->success(new NoteResource($note), 'Note created successfully', 201);
    }


    public function update(NoteRequest $request, Note $note)
    {
        // Retrieve validated data
        $validated = $request->validated();

        // Create DTO with all necessary parameters
        $dto = new NoteDTO(
            $validated['title'],
            $validated['description'],
            $validated['category_id'] ?? null  // Use null-coalescing operator for optional parameters
        );

        // Proceed with your service layer
        $updatedNote = $this->noteService->update($note, $dto);
        return $this->success(new NoteResource($updatedNote), 'Note updated successfully');
    }

    public function destroy(Note $note)
    {
        $this->noteService->delete($note);
        return $this->success(null, 'Note deleted successfully', 200);
    }
}
