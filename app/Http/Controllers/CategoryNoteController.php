<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Services\CategoryNoteService;
use App\DTOs\NoteDTO;
use App\Http\Resources\NoteResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use App\Models\Note;
use App\Traits\RespondsWithHttpStatus;

class CategoryNoteController extends Controller
{
    use RespondsWithHttpStatus;

    private CategoryNoteService $categoryNoteService;

    public function __construct(CategoryNoteService $categoryNoteService)
    {
        $this->categoryNoteService = $categoryNoteService;
    }

    public function index(Category $category): JsonResponse
    {
        $notes = $this->categoryNoteService->getAll($category);

        Log::info('Retrieved notes for category', [
            'category_id' => $category->id,
            'notes_count' => $notes->total(),
        ]);

        return $this->success(NoteResource::collection($notes), 'Notes retrieved successfully');
    }

    public function store(NoteRequest $request, Category $category): JsonResponse
    {
        $dto = NoteDTO::from($request->validated() + ['category_id' => $category->id]);

        $note = $this->categoryNoteService->create($dto->toArray(), $category);

        Log::info('Note created successfully in category', [
            'category_id' => $category->id,
            'note_id' => $note->id,
        ]);

        return $this->success(new NoteResource($note), 'Note created successfully', JsonResponse::HTTP_CREATED);
    }

    public function update(NoteRequest $request, Category $category, Note $note): JsonResponse
    {
        $dto = NoteDTO::from($request->validated() + ['category_id' => $category->id]);

        $updatedNote = $this->categoryNoteService->update($dto->toArray(), $category, $note);

        Log::info('Note updated successfully in category', [
            'category_id' => $category->id,
            'note_id' => $updatedNote->id,
        ]);

        return $this->success(new NoteResource($updatedNote), 'Note updated successfully');
    }

    public function destroy(Category $category, Note $note): JsonResponse
    {
        $this->categoryNoteService->delete($category, $note);

        Log::info('Note deleted successfully from category', [
            'category_id' => $category->id,
        ]);

        return $this->success(null, 'Note deleted successfully', JsonResponse::HTTP_OK);
    }
}
