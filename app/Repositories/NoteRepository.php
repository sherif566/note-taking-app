<?php

namespace App\Repositories;

use App\Models\Note;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

/**
 * @method LengthAwarePaginator search(array $filters = [], int $perPage, int $page)
 */
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
}
