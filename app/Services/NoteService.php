<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Note;
use App\DTOs\NoteDTO;
use App\Repositories\NoteRepository;
use App\Interfaces\RepositoryInterface;

class NoteService
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
    // General Methods (for all notes)

    public function getAll()
    {
        return $this->noteRepository->all();
    }

    public function create(NoteDTO $dto)
    {
        return $this->noteRepository->create([
            'title' => $dto->title,
            'description' => $dto->description,
            'category_id' => $dto->category_id,
        ]);
    }

    public function update(Note $note, NoteDTO $dto)
    {
        return $this->noteRepository->update($note, [
            'title' => $dto->title,
            'description' => $dto->description,
            'category_id' => $dto->category_id,
        ]);
    }

    public function delete(Note $note)
    {
        return $this->noteRepository->delete($note);
    }

    ////////////////////////////// Category-Specific Methods //////////////////////////////////////

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

