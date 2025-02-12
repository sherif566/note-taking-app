<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Note;
use App\DTOs\NoteDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Config\PaginationConfig;
use Illuminate\Support\Facades\Log;

class CategoryNoteService
{
    public function __construct()
    {
        Log::debug('Initializing CategoryNoteService');
    }

    public function getAll(Category $category): LengthAwarePaginator
    {
        Log::info('Fetching all notes for category', ['category_id' => $category->id]);

        $notes = $category->notes()->paginate(PaginationConfig::defaultSize());

        Log::info('Fetched notes for category', ['category_id' => $category->id, 'total_notes' => $notes->total()]);
        return $notes;
    }

    public function create(array $data, Category $category): Note
    {
        Log::info('Creating a new note in category', ['category_id' => $category->id, 'data' => $data]);

        $dto = new NoteDTO($data['title'], $data['description'], $category->id);
        $note = Note::create($dto->toArray());

        Log::info('Note created successfully', ['note_id' => $note->id, 'category_id' => $category->id]);
        return $note;
    }

    public function update(array $data, Category $category, Note $note): Note
    {
        Log::info('Updating note in category', ['note_id' => $note->id, 'category_id' => $category->id, 'data' => $data]);

        if ($note->category_id !== $category->id) {
            Log::warning('Note update failed: Note does not belong to this category', ['note_id' => $note->id, 'category_id' => $category->id]);
            throw new \Exception('Note does not belong to this category');
        }

        $dto = new NoteDTO($data['title'], $data['description'], $category->id);
        $note->update($dto->toArray());

        Log::info('Note updated successfully', ['note_id' => $note->id, 'category_id' => $category->id]);
        return $note;
    }

    public function delete(Category $category, Note $note): void
    {
        Log::info('Deleting note from category', ['note_id' => $note->id, 'category_id' => $category->id]);

        if ($note->category_id !== $category->id) {
            Log::warning('Note deletion failed: Note does not belong to this category', ['note_id' => $note->id, 'category_id' => $category->id]);
            throw new \Exception('Note does not belong to this category');
        }

        $note->delete();

        Log::info('Note deleted successfully', ['note_id' => $note->id, 'category_id' => $category->id]);
    }
}
