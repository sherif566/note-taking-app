<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;
use App\Models\Note;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class NoteRepository implements RepositoryInterface
{
    public function all($perPage = 10): LengthAwarePaginator
    {
        return Note::with('category')->paginate($perPage);
    }

    public function create(array $data): Note
    {
        return Note::create($data);
    }

    public function update($note, array $data): Note
    {
        if (!($note instanceof Note)) {
            throw new \InvalidArgumentException("Expected instance of Note.");
        }

        return tap($note, function ($note) use ($data) {
            $note->update($data);
            Log::info('Note updated', ['note_id' => $note->id]);
        });
    }

    public function delete($note): bool
    {
        if (!($note instanceof Note)) {
            throw new \InvalidArgumentException("Expected instance of Note.");
        }

        return $note->delete();
    }
}
