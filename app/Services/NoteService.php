<?php

namespace App\Services;

use App\Interfaces\RepositoryInterface;
use App\DTOs\NoteDTO;
use App\Models\Note;

class NoteService
{
    private RepositoryInterface $noteRepository;

    public function __construct(RepositoryInterface $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

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
}
