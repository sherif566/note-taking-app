<?php

namespace App\Services;

use App\Repositories\Interfaces\RepositoryInterface;
use App\DTOs\NoteDTO;
use App\Models\Note;
use App\Models\Category;

class CategoryNoteService
{
    private RepositoryInterface $noteRepository;

    public function __construct(RepositoryInterface $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    private function validateNoteCategory(Note $note, Category $category)
    {
        if ($note->category_id !== $category->id) {
            throw new \Exception('Note does not belong to this category');
        }
    }

    public function createNoteInCategory(NoteDTO $dto, Category $category)
    {
        return $this->noteRepository->create([
            'title' => $dto->title,
            'description' => $dto->description,
            'category_id' => $category->id,
        ]);
    }

    public function updateNoteInCategory(Note $note, NoteDTO $dto, Category $category)
    {
        $this->validateNoteCategory($note, $category);
        return $this->noteRepository->update($note, [
            'title' => $dto->title,
            'description' => $dto->description,
            'category_id' => $category->id,
        ]);
    }

    public function deleteNoteFromCategory(Category $category, Note $note)
    {
        $this->validateNoteCategory($note, $category);
        return $this->noteRepository->delete($note);
    }
}
