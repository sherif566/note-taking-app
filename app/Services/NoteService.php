<?php

namespace App\Services;

use App\DTOs\NoteDTO;
use App\DTOs\NoteSearchDTO;
use App\Models\Note;
use App\Repositories\NoteRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class NoteService
{
    private NoteRepository $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->noteRepository->all();
    }

    public function search(NoteSearchDTO $dto): LengthAwarePaginator
    {
        return $this->noteRepository->search($dto);
    }

    public function create(NoteDTO $dto): Note
    {
        return $this->noteRepository->create($dto->toArray());
    }

    public function update(Note $note, NoteDTO $dto): Note
    {
        return $this->noteRepository->update($note, $dto->toArray());
    }

    public function delete(Note $note): bool
    {
        return $this->noteRepository->delete($note);
    }
}
