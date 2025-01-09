<?php

namespace App\Services;

use App\Repositories\Interfaces\CRUDInterface;
use App\DTOs\NoteDTO;
use App\Models\Note;
use App\Models\Category;

class CategoryNoteService
{
    private CRUDInterface $noteRepository;

    public function __construct(CRUDInterface $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    private function validate(Note $note, Category $category)
    {
        if ($note->category_id !== $category->id) {
            throw new \Exception('Note does not belong to this category');
        }
    }

    public function create(NoteDTO $dto, Category $category)
    {
        return $this->noteRepository->create([
            'title' => $dto->title,
            'description' => $dto->description,
            'category_id' => $category->id,
        ]);
    }

    public function update(Note $note, NoteDTO $dto, Category $category)
    {
        $this->validate($note, $category);
        return $this->noteRepository->update($note, [
            'title' => $dto->title,
            'description' => $dto->description,
            'category_id' => $category->id,
        ]);
    }

    public function delete(Category $category, Note $note)
    {
        $this->validate($note, $category);
        return $this->noteRepository->delete($note);
    }
}
