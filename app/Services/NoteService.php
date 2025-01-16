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
        $query = Note::query();

        if ($dto->title) {
            $query->where('title', 'LIKE', "%{$dto->title}%");
        }

        if ($dto->description) {
            $query->where('description', 'LIKE', "%{$dto->description}%");
        }

        if ($dto->category_id) {
            $query->where('category_id', $dto->category_id);
        }

        return $query->paginate($dto->per_page, ['*'], 'page', $dto->page);
    }

    public function create(NoteDTO $dto): Note
    {
        return $this->noteRepository->create([
            'title' => $dto->title,
            'description' => $dto->description,
            'category_id' => $dto->category_id,
        ]);
    }

    public function update(Note $note, NoteDTO $dto): Note
    {
        return $this->noteRepository->update($note, [
            'title' => $dto->title,
            'description' => $dto->description,
            'category_id' => $dto->category_id,
        ]);
    }

    public function delete(Note $note): bool
    {
        return $this->noteRepository->delete($note);
    }
}
