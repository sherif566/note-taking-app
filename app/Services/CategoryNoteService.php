<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Note;
use App\DTOs\NoteDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Config\PaginationConfig;

class CategoryNoteService
{
    public function getall(Category $category): LengthAwarePaginator
    {
        return $category->notes()->paginate(PaginationConfig::defaultSize());
    }

    public function create(array $data, Category $category): Note
    {
        $dto = new NoteDTO($data['title'], $data['description'], $category->id);
        return Note::create($dto->toArray());
    }

    public function update(array $data, Category $category, Note $note): Note
    {
        if ($note->category_id !== $category->id) {
            throw new \Exception('Note does not belong to this category');
        }

        $dto = new NoteDTO($data['title'], $data['description'], $category->id);
        $note->update($dto->toArray());
        return $note;
    }

    public function delete(Category $category, Note $note): void
    {
        if ($note->category_id !== $category->id) {
            throw new \Exception('Note does not belong to this category');
        }

        $note->delete();
    }
}
