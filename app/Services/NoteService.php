<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Note;
use App\Repositories\NoteRepository;

class NoteService
{
    protected $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    // General Methods (for all notes)

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
        $note = $this->noteRepository->findById($id);
        return $this->noteRepository->update($note, $data);
    }

    public function deleteNote(Note $note)
    {
        return $this->noteRepository->delete($note);
    }




    ////////////////////////////// Category-Specific Methods //////////////////////////////////////

    public function createNoteInCategory(array $data, Category $category)
    {
        $data['category_id'] = $category->id;
        return $this->noteRepository->create($data);
    }

    public function updateNoteInCategory(array $data, Category $category, Note $note)
    {
        if ($note->category_id !== $category->id) {
            throw new \Exception('Note does not belong to this category');
        }
        return $this->noteRepository->update($note, $data);
    }

    public function deleteNoteFromCategory(Category $category, Note $note)
    {
        if ($note->category_id !== $category->id) {
            throw new \Exception('Note does not belong to this category');
        }
        return $this->noteRepository->delete($note);
    }
}
