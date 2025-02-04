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
        Log::info('Fetching notes for category started.', ['category_id' => $category->id]);

        $notes = $this->categoryNoteService->getAll($category);

        Log::info('Fetched notes for category successfully.', [
            'category_id' => $category->id,
            'notes_count' => $notes->total(),
        ]);

        return $this->success(NoteResource::collection($notes), 'Notes retrieved successfully');
    }

    public function store(NoteRequest $request, Category $category): JsonResponse
    {
        Log::info('Note creation started.', [
            'category_id' => $category->id,
            'request_data' => $request->validated(),
        ]);

        $dto = NoteDTO::from($request->validated() + ['category_id' => $category->id]);
        $note = $this->categoryNoteService->create($dto->toArray(), $category);

        Log::info('Note created successfully.', [
            'category_id' => $category->id,
            'note_id' => $note->id,
        ]);

        return $this->success(new NoteResource($note), 'Note created successfully', JsonResponse::HTTP_CREATED);
    }

    public function update(NoteRequest $request, Category $category, Note $note): JsonResponse
    {
        Log::info('Note update started.', [
            'category_id' => $category->id,
            'note_id' => $note->id,
            'request_data' => $request->validated(),
        ]);

        $dto = NoteDTO::from($request->validated() + ['category_id' => $category->id]);
        $updatedNote = $this->categoryNoteService->update($dto->toArray(), $category, $note);

        Log::info('Note updated successfully.', [
            'category_id' => $category->id,
            'note_id' => $updatedNote->id,
        ]);

        return $this->success(new NoteResource($updatedNote), 'Note updated successfully');
    }

    public function destroy(Category $category, Note $note): JsonResponse
    {
        Log::info('Note deletion started.', [
            'category_id' => $category->id,
            'note_id' => $note->id,
        ]);

        $this->categoryNoteService->delete($category, $note);

        Log::info('Note deleted successfully.', [
            'category_id' => $category->id,
            'note_id' => $note->id,
        ]);

        return $this->success(null, 'Note deleted successfully', JsonResponse::HTTP_OK);
    }
}
