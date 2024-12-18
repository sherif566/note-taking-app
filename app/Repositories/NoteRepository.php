<?php

namespace App\Repositories;

use App\Models\Note;

class NoteRepository
{
    public function getAll()
    {
        // Fetch all notes with their related categories
        return Note::with('category')->get();
    }

    public function findById($id)
    {
        // Find a note by its ID
        return Note::find($id);
    }

    public function create(array $data)
    {
        // Create a new note
        return Note::create($data);
    }

    public function update(Note $note, array $data)
    {
        // Update an existing note
        $note->update($data);
        return $note;
    }

    public function delete(Note $note)
    {
        // Delete the note
        return $note->delete();
    }
}
