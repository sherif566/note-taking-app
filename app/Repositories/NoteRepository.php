<?php

namespace App\Repositories;

use App\Models\Note;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;


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
    public function search(array $filters = [], int $perPage, int $page): LengthAwarePaginator
    {
        unset($filters['per_page'], $filters['page']);

        $query = $this->model->query();

        foreach ($filters as $column => $value) {
            if ($value !== null) {
                if (in_array($column, ['category_id'])) {
                    $query->where($column, $value);
                } else {
                    $query->where($column, 'LIKE', "%{$value}%");
                }
            }
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
