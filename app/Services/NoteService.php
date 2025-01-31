<?php

namespace App\Services;

use App\Repositories\Interfaces\CRUDInterface;
use App\DTOs\NoteDTO;
use App\DTOs\NoteSearchDTO;
use App\Models\Note;
use Illuminate\Pagination\LengthAwarePaginator;

class NoteService
{
    private CRUDInterface $noteRepository;

    public function __construct(CRUDInterface $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->noteRepository->all();
    }


    public function searchNotes(NoteSearchDTO $dto): LengthAwarePaginator
    {
        return $this->noteRepository->search(
            $dto->toArray(),
            $dto->per_page,
            $dto->page
        );
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
