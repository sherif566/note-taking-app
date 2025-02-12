<?php

namespace App\Repositories;

use App\Models\Note;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use App\DTOs\NoteSearchDTO;
use App\DTOs\PaginationDTO;


class NoteRepository extends BaseRepository
{
    public function __construct(Note $note)
    {
        parent::__construct($note);
    }

    public function update(Model $note, array $data): Note
    {
        if (!($note instanceof Note)) {
            throw new \InvalidArgumentException("Expected instance of Note.");
        }

        return tap($note, function (Note $note) use ($data) {
            $note->update($data);
            Log::info('Note updated', ['note_id' => $note->id]);
        });
    }

    public function search(NoteSearchDTO $dto): LengthAwarePaginator
    {
        $query = $this->model->query();

        if ($dto->title) {
            $query->where('title', 'LIKE', "%{$dto->title}%");
        }

        if ($dto->description) {
            $query->where('description', 'LIKE', "%{$dto->description}%");
        }

        if ($dto->category_id) {
            $query->where('category_id', $dto->category_id);
        }

        return $this->paginate($query);
    }


}
