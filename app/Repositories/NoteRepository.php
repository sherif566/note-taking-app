<?php

namespace App\Repositories;

use App\Models\Note;
use Illuminate\Support\Facades\Log;

class NoteRepository
{
    public function getAll($perPage = 10)
    {
        return Note::with('category')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Note::create($data);
    }

    public function update(Note $note, array $data)
    {
        return tap($note, function ($note) use ($data) {
            $note->update($data);

            Log::info('Note updated', ['note_id' => $note->id]);
        });
    }

    public function delete(Note $note)
    {
        return $note->delete();
    }
}
