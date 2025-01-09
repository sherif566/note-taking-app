<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Services\CategoryNoteService;
use App\Services\ValidationService;
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

    private CategoryNoteService $categoryNoteService;
    private ValidationService $validationService;

    public function __construct(CategoryNoteService $categoryNoteService, ValidationService $validationService)
    {
        $this->categoryNoteService = $categoryNoteService;
        $this->validationService = $validationService;
    }

    public function index($category): JsonResponse
    {
        $notes = Note::where('category_id', $category)->paginate(10);
        Log::info('Retrieved notes for category', ['category_id' => $category]);
        return $this->success(NoteResource::collection($notes), 'Notes retrieved successfully');
    }

    public function store(NoteRequest $request, Category $category): JsonResponse
    {
        if (!$this->validationService->validateNoteCategory(new Note, $category)) {
            return $this->error('Invalid category', [], JsonResponse::HTTP_BAD_REQUEST);
        }

        $dto = new NoteDTO(
            $request->get('title'),
            $request->get('description'),
            $category->id
        );

        $note = $this->categoryNoteService->create($dto, $category);
        Log::info("Note created in category successfully", [
            'category_id' => $category->id,
            'note_id' => $note->id
        ]);

        return $this->success(new NoteResource($note), 'Note created successfully', JsonResponse::HTTP_CREATED);
    }

    public function update(NoteRequest $request, Category $category, Note $note): JsonResponse
    {
        if (!$this->validationService->validateNoteCategory($note, $category)) {
            Log::warning('Mismatched category for note update', [
                'note_id' => $note->id,
                'expected_category_id' => $category->id,
                'actual_category_id' => $note->category_id,
            ]);

            return $this->error('Note does not belong to this category', [], JsonResponse::HTTP_NOT_FOUND);
        }

        $dto = new NoteDTO(
            $request->get('title'),
            $request->get('description'),
            $category->id
        );

        $updatedNote = $this->categoryNoteService->update($note, $dto, $category);
        Log::info("Note updated in category successfully", [
            'category_id' => $category->id,
            'note_id' => $updatedNote->id
        ]);

        return $this->success(new NoteResource($updatedNote), 'Note updated successfully');
    }

    public function destroy(Category $category, Note $note): JsonResponse
    {
        if (!$this->validationService->validateNoteCategory($note, $category)) {
            Log::warning('Mismatched category for note deletion', [
                'note_id' => $note->id,
                'expected_category_id' => $category->id,
                'actual_category_id' => $note->category_id,
            ]);

            return $this->error('Note does not belong to this category', [], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->categoryNoteService->delete($category, $note);
        Log::info("Deleting note from category", [
            'category_id' => $category->id,
            'note_id' => $note->id
        ]);

        return $this->success(null, 'Note deleted successfully', JsonResponse::HTTP_OK);
    }
}
