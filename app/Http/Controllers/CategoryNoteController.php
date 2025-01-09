<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Services\CategoryNoteService;
use App\DTOs\NoteDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\NoteResource;
use App\Models\Category;
use App\Models\Note;
use App\Traits\RespondsWithHttpStatus;

class CategoryNoteController extends Controller
{
    use RespondsWithHttpStatus;

    private CategoryNoteService $categorynoteService;

    public function __construct(CategoryNoteService $categorynoteService)
    {
        $this->categorynoteService = $categorynoteService;
    }

    public function index(Category $category): JsonResponse
    {
        $notes = Note::where('category_id', $category->id)->paginate(10);

        Log::info('Retrieved notes for category', [
            'category_id' => $category->id,
            'notes_count' => $notes->total(),
        ]);

        return $this->success(NoteResource::collection($notes), 'Notes retrieved successfully');
    }

    public function store(NoteRequest $request, Category $category): JsonResponse
    {
        $dto = new NoteDTO($request->validated() + ['category_id' => $category->id]);

        try {
            $note = $this->categorynoteService->create($dto, $category);
            Log::info("Note created in category successfully", [
                'category_id' => $category->id,
                'note_id' => $note->id,
            ]);

            return $this->success(new NoteResource($note), 'Note created successfully', JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error("Failed to create note in category", [
                'category_id' => $category->id,
                'error' => $e->getMessage(),
            ]);

            return $this->error('Failed to create note', [], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(NoteRequest $request, Category $category, Note $note): JsonResponse
    {
        if ($note->category_id !== $category->id) {
            Log::warning('Mismatched category for note update', [
                'note_id' => $note->id,
                'expected_category_id' => $category->id,
                'actual_category_id' => $note->category_id,
            ]);

            return $this->error('Note does not belong to this category', [], JsonResponse::HTTP_NOT_FOUND);
        }

        $dto = new NoteDTO($request->validated() + ['category_id' => $category->id]);

        try {
            $updatedNote = $this->categorynoteService->update($note, $dto, $category);

            Log::info("Note updated in category successfully", [
                'category_id' => $category->id,
                'note_id' => $updatedNote->id,
            ]);

            return $this->success(new NoteResource($updatedNote), 'Note updated successfully');
        } catch (\Exception $e) {
            Log::error("Failed to update note in category", [
                'note_id' => $note->id,
                'category_id' => $category->id,
                'error' => $e->getMessage(),
            ]);

            return $this->error('Failed to update note', [], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Category $category, Note $note): JsonResponse
    {
        if ($note->category_id !== $category->id) {
            Log::warning('Mismatched category for note deletion', [
                'note_id' => $note->id,
                'expected_category_id' => $category->id,
                'actual_category_id' => $note->category_id,
            ]);

            return $this->error('Note does not belong to this category', [], JsonResponse::HTTP_NOT_FOUND);
        }

        try {
            $this->categorynoteService->delete($category, $note);

            Log::info("Note deleted from category successfully", [
                'category_id' => $category->id,
                'note_id' => $note->id,
            ]);

            return $this->success(null, 'Note deleted successfully', JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            Log::error("Failed to delete note from category", [
                'note_id' => $note->id,
                'category_id' => $category->id,
                'error' => $e->getMessage(),
            ]);

            return $this->error('Failed to delete note', [], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
