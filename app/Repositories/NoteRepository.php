<?php

namespace App\Repositories;

use App\Interfaces\NoteRepositoryInterface;
use App\Models\Note;
use Illuminate\Support\Facades\Log;

class NoteRepository implements NoteRepositoryInterface
{
    public function all($perPage = 10)
    {
        // Corresponds to `getAll` in the interface; we rename it to `all` to match the interface signature
        return Note::with('category')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Note::create($data);
    }

    public function update($note, $data)
    {
        // Ensure type hinting and parameter names align with the interface
        if (!($note instanceof Note)) {
            throw new \InvalidArgumentException("Expected instance of Note.");
        }

        return tap($note, function ($note) use ($data) {
            $note->update($data);
            Log::info('Note updated', ['note_id' => $note->id]);
        });
    }

    public function delete($note)
    {
        if (!($note instanceof Note)) {
            throw new \InvalidArgumentException("Expected instance of Note.");
        }

        return $note->delete();
    }
}
