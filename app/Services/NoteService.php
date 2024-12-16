<?php

namespace App\Services;

use App\Repositories\NoteRepository;

class NoteService
{
    protected $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function getAllNotes()
    {
        return $this->noteRepository->getAll();
    }

    public function findNoteById($id)
    {
        return $this->noteRepository->findById($id);
    }

    public function createNote(array $data)
    {
        return $this->noteRepository->create($data);
    }

    public function updateNote($id, array $data)
    {
        // Find the note by its ID
        $note = $this->noteRepository->findById($id);

        // Check if the note exists
        if (!$note) {
            throw new \Exception('Note not found');
        }

        // Pass the note model to the repository's update method
        return $this->noteRepository->update($note, $data);
    }

    public function deleteNote($note)
    {
        return $this->noteRepository->delete($note);
    }
}
