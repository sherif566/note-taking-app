<?php

namespace App\Services;

use App\Repositories\Interfaces\CRUDInterface;
use App\DTOs\NoteDTO;
use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

class NoteService
{
    private CRUDInterface $noteRepository;

    public function __construct(CRUDInterface $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function getAll($search = null): Collection
    {
        $query = Note::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        return $query->get();
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
