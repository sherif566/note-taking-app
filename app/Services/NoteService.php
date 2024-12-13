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

    public function updateNote($note, array $data)
    {
        return $this->noteRepository->update($note, $data);
    }

    public function deleteNote($note)
    {
        return $this->noteRepository->delete($note);
    }
}
