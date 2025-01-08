<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Services\CategoryNoteService;
use App\DTOs\NoteDTO;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\NoteResource;
use App\Models\Category;
use App\Models\Note;

class CategoryNoteController extends Controller
{
    private CategoryNoteService $categorynoteService;

    public function __construct(CategoryNoteService $categorynoteService)
    {
        $this->categorynoteService = $categorynoteService;
    }

    public function index($category): AnonymousResourceCollection
    {
        $notes = Note::where('category_id', $category)->paginate(10);
        return NoteResource::collection($notes);
    }

    public function store(NoteRequest $request, Category $category): NoteResource
    {
        $dto = new NoteDTO(
            title: $request->get('title'),
            description: $request->get('description'),
            category_id: $category->id
        );

        $note = $this->categorynoteService->createNoteInCategory($dto, $category);

        Log::info("Note created in category successfully", [
            'category_id' => $category->id,
            'note_id' => $note->id
        ]);

        return new NoteResource($note);
    }

    public function update(NoteRequest $request, Category $category, Note $note): NoteResource
    {
        if ($note->category_id !== $category->id) {
            return response()->json(['error' => 'Note does not belong to this category'], Response::HTTP_NOT_FOUND);
        }

        $dto = new NoteDTO(
            title: $request->get('title'),
            description: $request->get('description'),
            category_id: $category->id
        );

        $updatedNote = $this->categorynoteService->updateNoteInCategory($note, $dto, $category);

        Log::info("Note updated in category successfully", [
            'category_id' => $category->id,
            'note_id' => $updatedNote->id
        ]);

        return new NoteResource($updatedNote);
    }

    public function destroy(Category $category, Note $note): JsonResponse
    {
        if ($note->category_id !== $category->id) {
            return response()->json(['error' => 'Note does not belong to this category'], Response::HTTP_NOT_FOUND);
        }

        Log::info("Deleting note from category", [
            'category_id' => $category->id,
            'note_id' => $note->id
        ]);

        $this->categorynoteService->deleteNoteFromCategory($category, $note);

        Log::info("Note deleted from category successfully", [
            'category_id' => $category->id,
            'note_id' => $note->id
        ]);

        return response()->json(['message' => 'Note deleted successfully'], Response::HTTP_OK);
    }
}
